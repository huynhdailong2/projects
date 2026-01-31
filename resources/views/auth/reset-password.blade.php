<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .reset-card {
            max-width: 420px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);
        }
    </style>
</head>

<body>

    <div class="card reset-card p-4">
        <div class="text-center mb-3">
            <h4 class="fw-bold">Đặt lại mật khẩu</h4>
            <p class="text-muted mb-0">Nhập email và mật khẩu mới</p>
        </div>

        {{-- Thông báo --}}
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    placeholder="example@gmail.com" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Ít nhất 6 ký tự" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nhập lại mật khẩu</label>
                <input type="password" name="password_confirmation" class="form-control"
                    placeholder="Nhập lại mật khẩu" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Đổi mật khẩu
            </button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ url('/login') }}" class="text-decoration-none small">
                ← Quay lại đăng nhập
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>