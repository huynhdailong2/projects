<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Danh sách người dùng</title>
    <style>
        /* General Styles */
        body {
      
            font-family: 'Arial', sans-serif;
            margin: 0;
            display: flex;
        }

        /* Body wrapper to allow space for sidebar */
        .body-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-left: 250px; /* Adjust for sidebar width */
            transition: margin-left 0.3s ease;
        }

        /* Form Container Styling */
        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
          
            padding: 10px;
            width: 80%;
            max-width: 400px;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Table Styling */
        .table {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .table tr:hover {
            background-color: rgba(173, 216, 230, 0.5);
            transition: background-color 0.3s ease;
        }

        /* Button Styling */
        .btn-custom {
            background: linear-gradient(to right, #5ed6fa, #54bbff);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: transform 0.3s, background 0.3s;
            cursor: pointer;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
            transform: scale(1.05);
        }

        /* Input Field Styling */
        .form-control {
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border 0.3s;
        }

        .form-control:focus {
            border-color: #ff7e5f;
            box-shadow: 0 0 5px rgba(255, 126, 95, 0.5);
        }

        /* Media Query for Small Screens */

    </style>
</head>

<body>
    @include('dashboard')
    <div class="body-wrapper">
        <div class="container mt-5">
            <h1 class="text-center">Danh sách người dùng</h1>
            <form action="/cap-nhat-user" method="post" class="mt-4">
                @csrf
                <table class="table table-hover">
                    <tr>
                        <td>ID</td>
                        <td>
                            {{$user[0]->id}}
                            <input type="hidden" value="{{$user[0]->id}}" name="txt_id">
                        </td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><input type="text" class="form-control" value="{{$user[0]->username}}" name="txt_username" required></td>
                    </tr>
                    <tr>
                        <td>Full Name</td>
                        <td><input type="text" class="form-control" value="{{$user[0]->fullname}}" name="txt_fullname" required></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td><input type="text" class="form-control" value="{{$user[0]->password}}" name="txt_password" required></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-custom">Cập nhật</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>

</html>
