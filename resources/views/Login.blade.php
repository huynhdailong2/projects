<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <title>Login</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #9fedff, #c9f0ff);
            height: 100vh;
        }

        .card {
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            padding: 50px;
        }

        h5 {
            font-size: 24px;
            font-weight: bold;
            color: #4a4a4a;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px;
            font-size: 16px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 6px rgba(0, 123, 255, 0.4);
        }

        /* Button login */
        .btn-primary {
            background: linear-gradient(to right, #007bff, #0056b3);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 16px;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #0056b3, #003d80);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider span {
            padding: 0 12px;
            font-size: 13px;
            color: #6c757d;
        }

        /* Google button */
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background-color: #fff;
            border: 1px solid #ddd;
            color: #444;
            font-weight: 500;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        .btn-google:hover {
            background-color: #f1f1f1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            color: #000;
        }

        /* Register link */
        .btn-register {
            color: #007bff;
            font-weight: 500;
            text-decoration: none;
        }

        .btn-register:hover {
            text-decoration: underline;
        }

        .small {
            font-size: 12px;
            color: #6c757d;
            text-decoration: none;
        }

        .small:hover {
            text-decoration: underline;
        }

        .img-fluid {
            border-radius: 20px 0 0 20px;
            height: 100%;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .img-fluid {
                display: none;
            }

            .card-body {
                padding: 30px;
            }
        }
    </style>
</head>

<body>

<section class="vh-100 d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
                <div class="card">
                    <div class="row g-0">

                        <!-- Image -->
                        <div class="col-md-6 d-none d-md-block">
                            <img src="https://s3-img-gw.longvan.net/img/files-store-longvan/public/1732765046280-118981-1732765046118.jpeg/size=1200x900"
                                 alt="login"
                                 class="img-fluid">
                        </div>

                        <!-- Form -->
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="card-body w-100">

                                <form action="{{ route('user.login') }}" method="post">
                                    @csrf

                                    <!-- Alerts -->
                                    @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif

                                    @if (session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                    @endif

                                    <h5 class="text-center">Sign into your account</h5>

                                    <div class="mb-4">
                                        <label class="form-label">Username hoặc Email</label>
                                        <input type="text"
                                            name="login"
                                            class="form-control"
                                            value="{{ old('login') }}"
                                            placeholder="Nhập username hoặc email"
                                            required>
                                    </div>


                                    <div class="mb-4">
                                        <label class="form-label">Password</label>
                                        <input type="password"
                                               name="password"
                                               class="form-control"
                                               required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">
                                        Login
                                    </button>

                                    <!-- Google login -->
                                    <div class="divider">
                                        <span>OR</span>
                                    </div>
                                    <a href="{{ route('login.google') }}" class="btn-google w-100 mb-3">
                                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
                                        <span>Continue with Google</span>
                                    </a>
                                    <p class="mt-4 text-center">
                                        Chưa có tài khoản?
                                        <a href="{{ route('user.register.form') }}" class="btn-register">
                                            Đăng kí ngay
                                        </a>
                                        <a href="{{ route('password.request') }}" class="btn-register">
                                            Quên mật khẩu
                                        </a>
                                    </p>
                                </form>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
