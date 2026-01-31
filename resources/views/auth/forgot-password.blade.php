<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>

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
        .forgot-card {
            max-width: 420px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,.15);
        }
    </style>
</head>
<body>

<div class="card forgot-card p-4">
    <div class="text-center mb-3">
        <h4 class="fw-bold"> Quên mật khẩu</h4>
        <p class="text-muted mb-0">
            Nhập email để nhận link đặt lại mật khẩu
        </p>
    </div>

    {{-- Thông báo thành công --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Lỗi validate --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                placeholder="example@gmail.com"
                value="{{ old('email') }}"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Gửi link khôi phục
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
