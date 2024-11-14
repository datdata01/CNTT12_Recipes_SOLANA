<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao hàng thành công</title>
</head>

<body>
    <h2>Xin chào {{ $order->user->name }},</h2>
    <p>Chúng tôi vui mừng thông báo rằng đơn hàng #{{ $order->id }} của bạn đã được giao thành công.</p>
    <p>Thông tin đơn hàng:</p>
    <ul>
        <li><strong>Mã đơn hàng:</strong> #{{ $order->code }}</li>
        <li><strong>Ngày đặt hàng:</strong> {{ $order->created_at->format('d-m-Y') }}</li>
        <li><strong>Trạng thái:</strong> Đã hoàn tất</li>
    </ul>

    <p>Bạn có thể xem chi tiết đơn hàng của mình <a href="{{ url('/profile/order/' . $order->id) }}">tại đây</a>.</p>

    <p>Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!</p>
</body>

</html>
