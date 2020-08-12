<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User\Plan;
use \Stripe\Plan as StripePlan;

class PlanController extends Controller
{
    //
    public function create_stripe_plan(Request $request, Plan $plan)
    {
        
        $planName = $plan->name;
        $amount = $plan->cost * 100;
        $apiId = uniqid();
        $playType = "month";
        if($plan->id == 3 || $plan->id == 4)
            $playType = "year";

        $secretKey = \Config::get('services.stripe.secret');
        \Stripe\Stripe::setApiKey($secretKey);
        $newPlan = StripePlan::create(array(
            "amount" => $amount,
            "interval" => $playType,
            "product" => array(
              "name" => $planName
            ),
            "currency" => "eur",
            "id" => $apiId
          ));
        $plan->slug = $newPlan->id;;
        $plan->save();
        echo "Plan created.";
    }

}
