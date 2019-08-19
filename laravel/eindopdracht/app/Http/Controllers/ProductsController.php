<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\Products;
use App\Model\Category;
use App\Model\Comments;
use App\Model\Fundings;
use App\Model\Spotlight;
use App\Model\Image;
use App\Mail\Fundmail;


use App\User;
use PDF;

class ProductsController extends Controller
{
    //hier alle functies van products mapje (create, detailpage, edit en products)
    public function products(){
        $productsAll = Products::all()->sortBy('category_id');
        return view("products/products")->with(compact('productsAll'));
    }

    public function detailPage($product_id){
        $commentAll = Comments::all();
        $firstimage = Image::all()->where('products_id', $product_id)->first();
        $imageAll = Image::where('products_id', $product_id)->simplePaginate(2);
        $products = Products::where('id', $product_id)->first();
        $category = Category::where('id', $products->category_id)->first();
        $user = User::where('id', $products->user_id)->first();
        $funded = Fundings::all()->where('product_id', $product_id)->sum('amount');
        $fundList = Fundings::all()->where('product_id', $product_id);
        return view("products/detailpage")->with(compact('products','category', 'user','commentAll','funded','fundList','firstimage','imageAll'));
    }

    public function create(){
        if(Auth::user()){
            $categoryAll = Category::all();
            return view("products/create")->with(compact('categoryAll'));
        }else{
            return redirect()->back()->with('fail', 'niet ingelogd');
        }
    }

    public function edit($products_id){
        $selectedProduct = Products::where('id', $products_id)->first();
        $categoryAll = Category::all();

        return view("products/edit")->with(compact('selectedProduct','categoryAll'));
    }

    public function update($products_id){
        $product = Products::findOrFail($products_id);

        $data = [
            'title' => request('title'),
            'content' => request('content'),
            'category_id' => request('category'),
            'deadline' => request('deadline'),
            'targetsum' => request('targetsum'),
            'user_id' => Auth::user()->id,
        ];
        $product->update($data);
        return redirect(route('Products'));
    }

    public function delete($products_id){
        Products::where('id', $products_id)->delete();
        return redirect('/products');
    }

    public function save(Request $request){
        \request()->validate([
            'title' => 'required',
            'content' => 'required',
            'category' => 'required',
            'deadline' => 'required',
            'targetsum' => 'required',
        ]);
        $data = [
            'title' => request('title'),
            'content' => request('content'),
            'category_id' => request('category'),
            'deadline' => request('deadline'),
            'targetsum' => request('targetsum'),
            'user_id' => Auth::user()->id,
        ];
        Products::create($data);
        return redirect()->back()->with('succes', 'aangemaakt');
    }

    public function comment(Request $request, $product_id){
        $data = [
            'comment' => request('comment'),
            'product_id' => $product_id,
            'user_id' => Auth::user()->id,
            'username' => Auth::user()->name,
        ];
        Comments::create($data);
        return redirect()->back()->with('succes', 'You placed a comment');
    }

    public function fund(Request $request, $product_id){
        $credits = Auth::user()->credits;
        $amount = request('amount');

        if($credits - $amount < 0)  {
            return redirect()->back()->with('fail', 'You do not have enough credits');
        }else{
            $currentProduct = Products::where('id', $product_id)->first();
            User::where('id', Auth::user()->id)
            ->update(['credits' => $credits - $amount]);
            $productCreator = User::where('id', $currentProduct->user_id)->first();
            User::where('id',$productCreator->id )
            ->update(['credits' => $productCreator->credits + ($amount*0.9)]);
            $admin = User::where('type', 'admin')->first();
            User::where('type','admin' )
            ->update(['credits' => $admin->credits + ($amount*0.1)]);

            $data = [
                'amount' => $amount * 0.9,
                'product_id' => $product_id,
                'user_id' => Auth::user()->id,
                'username' => Auth::user()->name,
            ];
            Fundings::create($data);
            //$mail = new Fundmail();
            //Mail::to($productCreator->email)->send($mail);
            return redirect()->back()->with('succes', 'You made a funding');
        }    
        return redirect()->back()->with('succes', 'You placed a funding');
    }

    public function spotlight($product_id){
        $credits = Auth::user()->credits;
        $product = Products::where('id', $product_id)->first();
        $firstimage = Image::all()->where('products_id', $product_id)->first();
        if($credits - 1400 < 0){
            return redirect()->back()->with('fail', 'You do not have enough credits');
        }
        else 
        {
            if (Spotlight::where('product_id', $product_id)->first() === null ){
                User::where('id', Auth::user()->id)->update(["credits"=>$credits - 1400]);
                $data = [
                    'product_id' => $product_id,
                    'filepath' =>$firstimage->filepath,
                    'filename' =>$firstimage->filename,
                ];
                Spotlight::create($data);
                return redirect()->back()->with('succes', 'Your product is added to the spotlight');

            } else{
                return redirect()->back()->with('fail', 'This product is already in the spotlight');
            }
        }
    }

    public function store(Request $request){
        if (Auth::user()){
            $rules = [
                'product_id' => 'required|numeric',
                'file' => 'required',
                'file.*' => 'image|mimes:jpeg,jpg,png,gif,svg|max:2048|required'
            ];
            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()){
                return Redirect::back()->withInput()
                                        ->withErrors($validator)
                                        ->with('fail' , 'Er ging iets mis');
            }
            if($request->hasFile('file')){
                $directory = 'product'.$request->product_id;

                foreach($request->file('file') as $image){
                    $name = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $filename = pathinfo($name, PATHINFO_FILENAME) . '-' . uniqid(5) . '.' . $extension;
                    $image->storeAs($directory, $filename, 'public');
                    $this->storeImageToDatabase($request->product_id, $filename, 'storage/'.$directory);
                }
                return back()->with('succes','De afbeelding/-en zijn geupload');
            }
        }
        else{
            return redirect('/')->with('fail','U bent niet ingelogd!');
        }
        
    }
    private function storeImageToDatabase( $product_id, $filename, $filepath){
        $image = new Image();
        $image->products_id = $product_id;
        $image->filename = $filename;
        $image->filepath = $filepath;

        $image->save();
        
    }
    public function pdf($product_id){
        $product = Products::where('id', $product_id)->first();
        $creator = User::where('id', $product->user_id)->first();
        $funded = Fundings::all()->where('product_id', $product_id)->sum('amount');
        $category = Category::all()->where('id', $product->category_id)->first()->name;
        $firstimage = Image::all()->where('products_id', $product_id)->first();

        $data = [
            'title' => $product->title,
            'content' => $product->content,
            'deadline' => $product->deadline,
            'targetsum' => $product->targetsum,
            'funded' => $funded,
            'creator' => $creator->name,
            'category' => $category,
            'filename' => $firstimage->filename,
            'filepath' => $firstimage->filepath,
        ];
        $pdf = PDF::loadView('PDF', array('data' => $data));
        return $pdf->stream($product->title.'.pdf');
    }

}
 