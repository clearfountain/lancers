<?php

namespace App\Http\Controllers;

use App\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    function showSubscriptions() {
        $data['plans'] = SubscriptionPlan::all();
        return view('pricing', $data);
    }

}
