<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Register</title>
    <style>
        body {
            background: url('your-background-image.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-main {
            background: linear-gradient(to bottom right, rgba(255, 255, 255, 0.8), rgba(200, 200, 200, 0.8));
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .btn-primary {
            background: linear-gradient(to right, #4b0082, #6a5acd);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #6a5acd, #4b0082);
        }

        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="form-main">
        <form action="{{ route('user.register.save') }}" method="post">
            @csrf <!-- Token CSRF -->
            <h1>Register</h1>

            <!-- Full Name -->
            <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" id="fullname" name="fullname" class="form-control" required value="{{ old('fullname') }}">
                @error('fullname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Username -->
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required value="{{ old('username') }}">
                @error('username')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                @error('password_confirmation')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Display success message if available -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Display error message if available -->
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <button type="submit" class="btn btn-primary w-100">Register</button>
            
        </form>
        <a href="{{ route('login.google') }}" class="btn-google w-100 mb-3">
                                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
                                        <span>Continue with Google</span>
                                    </a>
    </div>
</body>
</html>
