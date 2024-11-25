<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class PolicyController extends Controller
{
    public function privacy()
    {
        return view('client.pages.policies.privacy');
    }

    public function shipping()
    {
        return view('client.pages.policies.shipping');
    }

    public function return()
    {
        return view('client.pages.policies.return');
    }

    public function payment()
    {
        return view('client.pages.policies.payment');
    }
}
