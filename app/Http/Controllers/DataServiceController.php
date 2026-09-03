<?php

namespace App\Http\Controllers;

class DataServiceController extends Controller
{
    public function __invoke()
    {
        return view('dataservice.show');
    }
}
