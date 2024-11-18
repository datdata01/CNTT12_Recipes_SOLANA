<?php

namespace App\Http\Controllers;

use Flasher\Prime\Notification\NotificationInterface;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Refund;

class RefundController extends Controller
{
    public function index()
    {
        $refund = Refund::with('order')
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('admin.pages.refund.index', ['listRefund' => $refund]);
    }

    public function create()
    {
        $orders = Order::all();
        return view('admin.pages.refund.create', compact('orders'));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $refund = Refund::findOrFail($id);
        $orders = Order::all();
        return view("admin.pages.refund.update", compact('refund', 'orders'));
    }
}
