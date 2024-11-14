<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
        <h3 style="color: #333;">Chào mừng {{ $account->full_name }} đến với Gundam Win</h3>
        <p style="color: #555;">Hy vọng ta sẽ đồng hành nhiều trong tương lai</p>
        <p style="color: #555;">Để hoàn tất quá trình đăng ký, vui lòng xác thực tài khoản của bạn bằng cách bấm vào nút bên dưới:</p>
        <a href="{{ route('auth.verify-account', $account->email) }}"
           style="display: inline-block; margin-top: 20px; padding: 10px 15px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">
           Bấm đây để xác thực tài khoản của bạn
        </a>
    </div>
</body>
</html>
