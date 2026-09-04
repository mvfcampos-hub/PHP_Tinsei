<?php

namespace App\Http\Controllers;

class DataCountController extends Controller
{
    public function __invoke()
    {
        return view('datacount.show');
    }
}
