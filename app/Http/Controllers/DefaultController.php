<?php

namespace App\Http\Controllers;

class DefaultController extends Controller
{
    public function pageNotFound()
    {
        return view('errors.404-client');
    }
}
