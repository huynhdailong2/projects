<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <title>Add Users</title>
    <style>
        /* General Styles */
        body {
          
            margin: 0;
        }

        .body-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-left: 250px; /* Adjust for sidebar width */
            transition: margin-left 0.3s ease;
        }

        /* Form Container Styling */
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Form Input Styling */
        .form-control {
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #00f2fe;
            box-shadow: 0 0 5px rgba(0, 242, 254, 0.5);
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(to right, #5bd6ff, #8ff2ff);
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
        }

        /* Media Query for Small Screens */
        @media (max-width: 600px) {
            .body-wrapper {
                margin-left: 0; /* Remove margin for small screens */
            }
            .form-container {
                padding: 20px;
                max-width: 90%; /* Adjust form width for mobile screens */
            }
        }
    </style>
</head>

<body>
    @include('dashboard')
    
    

    <div class="body-wrapper">
            <form class="form-container" action="add-users" method="post">
                @csrf
                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            
                <h1>Add User</h1>
                <div class="mb-3">
                    <input type="text"  name="txt_username" class="form-control" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password"   name="txt_password" class="form-control" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input type="text"  name="txt_fullname" class="form-control" placeholder="Full Name" required>
                </div>
                <div class="mb-2">
                    <button type="submit" class="btn btn-primary btn-block ">Add</button>
                </div>
            </form>
    </div>
</body>

</html>
