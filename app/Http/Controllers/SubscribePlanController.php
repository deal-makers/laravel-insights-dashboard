<?php

namespace App\Http\Controllers;

use App\Models\User\SubscribePlan;
use Illuminate\Http\Request;
use App\Models\User\Plan;
use Stripe\PaymentMethod;
use Stripe\Stripe;
use Illuminate\Support\Facades\Auth;

class SubscribePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Plan $plan)
    {
        $user = Auth::user();
        $paymentMethod = json_decode($request->stripeToken, true);
        
        $result = $request->user()
        ->newSubscription('default', $plan->slug)
        ->create($paymentMethod['id']);
        
        if(isset($result->id)){
            $user->agreement_id = $result->id;
            $user->is_subscribed = 1;
            $user->subscribe_id = $plan->id;
            $user->plan_id = $plan->slug;
            $user->save();
            return view("user.subscriptions")->with("success", "New Subscriber Created and Billed Successfully");
        }
        return view("user.subscriptions")->with("fail", "Subscriber didn't Created");
    }

    /** 
     * Stripe subscribe cancel
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function cancel(Request $request)
    {
        if($request->user()->subscription('default')->cancelNow())
        {
            $user = Auth::user();
            $user->is_subscribed = 0;
            $user->subscribe_id = 0;
            $user->agreement_id = "";
            $user->plan_id = "";
            $user->card_brand = "";
            $user->card_last_four = "";
            $user->trial_ends_at = null;
            $user->save();
            return view("user.subscriptions")->with("success", "You have cancelled subscriber");
        } 
        return view("user.subscriptions")->with("success", "You have cancelled error.");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubscribePlan  $subscribePlan
     * @return \Illuminate\Http\Response
     */
    public function show(SubscribePlan $subscribePlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubscribePlan  $subscribePlan
     * @return \Illuminate\Http\Response
     */
    public function edit(SubscribePlan $subscribePlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubscribePlan  $subscribePlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubscribePlan $subscribePlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubscribePlan  $subscribePlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscribePlan $subscribePlan)
    {
        //
    }
}
