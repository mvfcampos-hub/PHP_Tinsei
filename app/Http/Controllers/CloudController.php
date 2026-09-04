<?php

namespace App\Http\Controllers;

use App\Models\CloudPlan;
use App\Models\Product;

class CloudController extends Controller
{
    public function __invoke()
    {
        $plans = CloudPlan::active()->get();
        $cloudProducts = Product::active()->category('cloud')->get();

        return view('cloud.show', compact('plans', 'cloudProducts'));
    }
}
