<?php

namespace App\Http\Controllers;

class DataClientController extends Controller
{
    public function __invoke()
    {
        return view('dataclient.show');
    }
}
