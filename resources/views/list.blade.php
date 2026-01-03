<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>Danh sách người dùng</title>
    <style>
        body {

            color: #333;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .body-wrapper {
            margin-left: 250px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        h1 {
            color: #fff;
            text-align: center;
            margin-top: 20px;
        }

        .table {
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            font-size: 0.85rem;
        }

        .table th {
            background: linear-gradient(#60a9fd, #6ce2ff);
            color: white;
            font-size: 0.9rem;
        }



        .btn-custom {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            border: none;
            font-size: 16px;
            transition: transform 0.3s, background 0.3s;
            cursor: pointer;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
            transform: scale(1.05);
        }

        .icon {
            width: 30px;
            transition: transform 0.3s;
        }

        .icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    @include('dashboard') <!-- Gắn sidebar -->
    <div class="body-wrapper">
        <h1>Danh sách người dùng</h1>
        <div class="text-center mb-4">
            <a href="add-user">
                <button type="button" class="btn btn-custom">Add</button>
            </a>
        </div>

        <table class="table table-hover mx-auto w-75">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Password</th>
                <th>Edit</th>
            </tr>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->fullname }}</td>
                    <td>{{ $user->password }}</td>
                    <td>
                        <a href="thong-tin-user/{{ $user->id }}">
                            <img src="{{ asset('img/edit.png') }}" alt="Edit" class="icon">
                        </a>
                        <a href="delete/{{ $user->id }}">
                            <img src="{{ asset('img/recycle-bin.png') }}" alt="Delete" class="icon">
                        </a>
                    </td>
                </tr>
            @endforeach
        {{-- </table>

        <h1 class="text-center mt-5">Cart</h1>
        <table class="table table-hover mx-auto w-75">
            <tr>
                <th>ID</th>
                <th>Item</th>
            </tr>
            @foreach ($cart as $key => $value)
                @php
                    $product = json_encode($value);
                    $product = json_decode($product);
                @endphp
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->item }}</td>
                </tr>
            @endforeach
        </table> --}}
    </div>
</body>

</html>
