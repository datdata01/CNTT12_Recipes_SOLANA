<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khôi phục mật khẩu</title>
    <style type="text/css">
        body {
            margin: 20px auto;
            font-family: 'Arial', sans-serif;
            background-color: #e2e2e2;
            text-align: center;
        }

        .container {
            background-color: white;
            width: 100%;
            max-width: 650px;
            box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.27);
            padding: 20px;
            border-radius: 8px;
        }

        h3 {
            color: #333;
        }

        p {
            font-size: 17px;
            color: #555;
        }

        .footer {
            background-color: rgb(248, 248, 248);
            padding: 24px;
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Xin chào {{ $user->fullName }}</h3>
        <p>Mật khẩu mới của bạn là: <strong>{{ $newPassword }}</strong></p>
        <p>Vui lòng đăng nhập và đổi mật khẩu ngay sau đó để bảo mật tài khoản.</p>
    </div>
</body>

</html>
