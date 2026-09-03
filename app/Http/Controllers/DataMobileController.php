<?php

namespace App\Http\Controllers;

class DataMobileController extends Controller
{
    public function __invoke()
    {
        return view('datamobile.show');
    }
}
