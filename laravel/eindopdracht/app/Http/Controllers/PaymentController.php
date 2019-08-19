<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\User;
use Stripe\Charge;
use Stripe\Stripe;
use App\Http\Controllers\Traits\ConvertCurrencyTrait;

class PaymentController extends Controller
{
    //
    use ConvertCurrencyTrait;

    public function getStripeForm() {
        if(Auth::user()){
            return view('user/credits');
        }
        else{
            return redirect()->back()->with('fail', 'U bent niet ingelogd!');
        }
    
    }

    public function postStripePayment(Request $r) {
      
        Stripe::setAPIKey(env('STRIPE_SECRET'));
        $price = 100;
        $user = Auth::user();
        $price = $this->convertWithEnvRate($r->credits) * 100;

        $description = 'De gebruiker ' .$user->name. ' heeft credits aangekocht';
        $charge = Charge::create([
            'amount' => $price,
            'currency' =>'eur',
            'source' => $r->stripeToken,
            'description' =>$description,
        ]);
        if($charge->status =='succeeded'){
            $user->credits += $r->credits;
            $user->save();
           
        }
        else{
            $r->session()->flash('error',
            'R.I.P ');
        }
        return back();
    }

}