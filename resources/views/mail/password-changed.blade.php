<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông báo đổi mật khẩu</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f4f6f8; padding:20px">

<div style="max-width:600px; margin:auto; background:#ffffff; padding:20px; border-radius:8px">
    <h2 style="color:#2563eb">Mật khẩu đã được thay đổi</h2>

    <p>Xin chào,</p>

    <p>Mật khẩu tài khoản của bạn đã được thay đổi thành công.</p>
    <p><strong>Mật khẩu mới:</strong> {{ $newPassword }}</p>

    <p style="color:red">
         Vui lòng đăng nhập và đổi lại mật khẩu nếu bạn không thực hiện hành động này.
    </p>

    <p>
        <a href="{{ url('/login') }}"
           style="display:inline-block; padding:10px 16px; background:#2563eb; color:#fff; text-decoration:none; border-radius:6px">
            Đăng nhập ngay
        </a>
    </p>

    <hr>

    <p style="font-size:12px; color:#666">
        Đây là email tự động, vui lòng không trả lời.
    </p>
</div>

</body>
</html>
