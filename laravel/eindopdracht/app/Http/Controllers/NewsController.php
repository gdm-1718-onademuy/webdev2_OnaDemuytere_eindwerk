<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\News;
use App\Model\Image;

class NewsController extends Controller
{
    //hier alle functies van news mapje (detailpage, overview)
    public function detailPage($news_id){
        $news = News::where('id', $news_id)->first();
        return view("news/detailpage")->with(compact('news'));
    }

    public function overview(){
        $newsAll = News::where('id','>',0)->paginate(4);

        return view("news/overview")->with(compact('newsAll'));
    }

    public function create(){
        if(Auth::user()){
            return view("news/create");
        }else{
            return redirect()->back()->with('fail', 'not logged in');
        }
    }

    public function save(Request $request ){
        $newsData = [
            'profile' => Auth::user()->name,
            'title' => request('title'),
            'content' => request('content'),
            'user_id' => Auth::user()->id,
        ];
        News::create($newsData);
        return redirect()->back();
    }

    public function edit($news_id){
        $selectedNews = News::where('id', $news_id)->first();
        return view('news/edit')->with(compact('selectedNews'));
    }

    public function update($news_id){
        $news = News::findOrFail($news_id);

        $data = [
            'title' => request('title'),
            'content' => request('content'),
        ];
        $news->update($data);
        return redirect('/news');
    }

    public function delete($news_id){
        News::where('id', $news_id)->delete();
        return redirect('/news');
    }

    public function store(Request $request){
        if (Auth::user()){
            $rules = [
                'news_id' => 'required|numeric',
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
                $directory = 'news'.$request->news_id;

                foreach($request->file('file') as $image){
                    $name = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $filename = pathinfo($name, PATHINFO_FILENAME) . '-' . uniqid(5) . '.' . $extension;
                    $image->storeAs($directory, $filename, 'public');
                    $this->storeImageToDatabase($request->news_id, $filename, 'storage/'.$directory);
                }
                return back()->with('succes','De afbeelding/-en zijn geupload');
            }
        }
        else{
            return redirect('/')->with('fail','U bent niet ingelogd!');
        }
        
    }
    private function storeImageToDatabase( $news_id, $filename, $filepath){
        $image = new Image();
        $image->news_id = $news_id;
        $image->filename = $filename;
        $image->filepath = $filepath;

        $image->save();
        
    }

}
