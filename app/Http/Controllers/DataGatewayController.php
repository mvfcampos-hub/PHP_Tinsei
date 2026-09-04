<?php

namespace App\Http\Controllers;

class DataGatewayController extends Controller
{
    public function __invoke()
    {
        return view('datagateway.show');
    }
}
