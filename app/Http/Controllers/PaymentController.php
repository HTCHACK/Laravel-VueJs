<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function payment()
    {

        $availablePlans = [
            'weekly'=>'Weekly',
            'monthly'=>'Monthly',
            'yearly'=>'Yearly',
        ];


        $data = [
            'intent' => auth()->user()->createSetupIntent(),
            'plans'=>$availablePlans,
        ];
        return view('pay')->with($data);
    }

    public function subscribe(Request $request)
    {
        $user = auth()->user();
        $paymentMethod = $request->payment_method;

        $planId = $request->plan;
        $user->newSubscription('main', $planId)->create($paymentMethod);

        return response([
            'success_url'=>redirect()->intended('/')->getTargetUrl(),
            'message'=>'success',
        ]);
    }
}
