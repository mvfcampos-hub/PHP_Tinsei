<?php

namespace App\Http\Controllers;

class DataStoreController extends Controller
{
    public function __invoke()
    {
        return view('datastore.show');
    }
}
