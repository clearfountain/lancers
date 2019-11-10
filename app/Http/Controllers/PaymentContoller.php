<?php

namespace App\Http\Controllers;

use Auth;
use Carbon\Carbon;
use App\Invoice;
use App\Transaction;
use App\Subscription;
use App\SubscriptionPlan;
use Illuminate\Http\Request;

class PaymentContoller extends Controller {

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($type) {
        $user = Auth::user();
  
        $subcriptions = SubscriptionPlan::all();
        $key = Transaction::$PYS_PUB_KEY;
        $txRef = Transaction::generateRef();

        $payment_types = [];
        $type = trim($type);

        // get all subscription plans and fill details in payment_types
        foreach ($subcriptions as $subcription) {

            $payment_types[$subcription->name] = [
                'name' => str_replace("_", " ", $subcription->name) . " plan",
                'amount' => $subcription->price,
                'type' => 'sub',
                'id' => $subcription->id,
                'redirect' => '/users/subscribe/',
                'key' => $key,
                'ref' => $txRef,
                'balance' => 0
            ];
        }


        if (in_array($type, array_keys($payment_types))) {

            // if the requested payment is a subcription
            $data = $payment_types[$type];

            // get the users current subcription
            $sub = $user->subscription;

            // check if there's still some days left for the plan to exprire, so as to remove the cost from the charge
            if ($sub) {
                if ($sub->plan_id > $data['id']) {
                    // return session value here
                    session()->flash('message.alert', 'danger');
                    session()->flash('message.content', "Sorry, you cannot downgrade your subscription");
                    return back();
                }

                if ($data['id'] > $sub->plan_id) {
                    $remaining = Carbon::parse($sub->enddate)->diffInDays(Carbon::parse($sub->startdate));
                    $plan = SubscriptionPlan::find($sub->plan_id);
                    //constraint to check for null value returned from db query
                    if ($plan !== null) {
                        $price_per_day = $plan->price / 30;

                        $balance = $price_per_day * $remaining;

                        $data['balance'] = $balance;
                    }
                    //if null value is returned cast balance to nill
                    $data['balance'] = 0;
                }
            }

            // if($data['id'] == 1){
            //     return redirect($data['redirect']);
            // }
            return view('pay')->with('data', $data);
        } else {
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Invalid Plan");
            return back();
        }
    }

    public function invoice($ref) {
        if ($ref == null) {
            session()->flash('message.alert', 'danger');
            session()->flash('message.content', "Invalid payment option");
            return back();
        } else {
            $invoice = Invoice::where('created_at', Carbon::createFromTimestamp($ref))->first();
            if (empty($invoice)) {
                session()->flash('message.alert', 'danger');
                session()->flash('message.content', "Invalid payment option ");
                return back();
            } else {
                if ($invoice->status == "paid") {
                    session()->flash('message.alert', 'danger');
                    session()->flash('message.content', "This invoice has been paid ");
                    return back();
                }
                $key = Transaction::$PYS_PUB_KEY;
                $txRef = Transaction::generateRef();
                $data = [
                    "name" => "Invoice #" . $ref,
                    "amount" => $invoice->amount,
                    "type" => 'invoice',
                    "redirect" => '/invoice/pay/',
                    "key" => $key,
                    'ref' => $txRef,
                    "id" => $invoice->id,
                    'balance' => 0
                ];
            }
            return view('pay')->with('data', $data);
        }
    }

}
