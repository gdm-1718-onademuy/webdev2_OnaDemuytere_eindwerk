<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Model\News;
use App\Model\Products;
use App\Model\Image;

class UserController extends Controller
{
    //hier alle functies van user mapje (profile, credits)
    public function profile(){
        //data van user ophalen
        $user = Auth::user();
        $articles = News::all()->where('user_id', $user->id);
        $products = Products::all()->where('user_id', $user->id);
        return view("user/profile")->with(compact('articles','products','user'));
    }
    public function credits(){
        return view("user/credits");
    }

    public function store(Request $request){
        if (Auth::user()){
            $rules = [
                'user_id' => 'required|numeric',
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
                $directory = 'user'.$request->user_id;

                foreach($request->file('file') as $image){
                    $name = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $filename = pathinfo($name, PATHINFO_FILENAME) . '-' . uniqid(5) . '.' . $extension;
                    $image->storeAs($directory, $filename, 'public');
                    $this->storeImageToDatabase($request->user_id, $filename, 'storage/'.$directory);
                }
                return back()->with('succes','De afbeelding/-en zijn geupload');
            }
        }
        else{
            return redirect('/')->with('fail','U bent niet ingelogd!');
        }
        
    }
    private function storeImageToDatabase( $user_id, $filename, $filepath){
        $image = new Image();
        $image->user_id = $user_id;
        $image->filename = $filename;
        $image->filepath = $filepath;

        $image->save();
        
    }
}
