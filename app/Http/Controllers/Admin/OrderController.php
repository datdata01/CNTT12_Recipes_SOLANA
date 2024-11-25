<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderSuccessEvent;
use App\Http\Controllers\Controller;
use App\Mail\OrderCompletedMail;
use App\Models\Order;
use Flasher\Prime\Notification\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product', 'user')
        ->latest('id')->paginate(12);

        return view('admin.pages.orders.index', compact('data'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::with('orderItems.productVariant.attributeValues.attribute', 'orderItems.productVariant.product')->findOrFail($id);
        // dd($order->toArray());
        return view('admin.pages.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::with('user')->findOrFail($id);
        // dd($order->toArray());
        $order->update($request->all());

        // Gửi email nếu trạng thái là SHIPPED
        if ($order->status === 'SHIPPED') {
//            Mail::to($order->user->email)->send(new OrderCompletedMail($order));
            OrderSuccessEvent::dispatch($order);
        }

        toastr("Cập nhật trạng thái đơn hàng thành công!", NotificationInterface::SUCCESS, "Thành công", [
            "closeButton" => true,
            "progressBar" => true,
            "timeOut" => "3000",
            "color" => "red"
        ]);

        return back();
    }
}
