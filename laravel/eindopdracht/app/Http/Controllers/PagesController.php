<?php

namespace App\Http\Controllers;

use App\Model\Page;
use App\Model\Spotlight;
use Carbon\Carbon;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    //hier alle functies van general mapje (about, contact, home en privacy-policy)
    public function home(){
        $spotlight = Spotlight::where('created_at', '>', Carbon::now()->subDays(7))->inRandomOrder()->limit(10)->get();
        $page = Page::where('id',1)->first(); //door de first kun je aan de attributen van de geselecteerde pagina
        return view("general/home")->with(compact('page', 'spotlight')); //al de data kan je nu hiermee aanvragen
    }

    public function contact(){
        $page = Page::where('id',3)->first();
        return view("general/contact")->with(compact('page'));
    }

    public function about(){
        $page = Page::where('id',2)->first();
        return view("general/about")->with(compact('page'));
    }

    public function privacyPolicy(){
        $page = Page::where('id',4)->first();
        return view("general/privacy-policy")->with(compact('page'));
    }

    


}
