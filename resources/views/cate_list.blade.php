<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách danh mục</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .body-wrapper {
            margin-left: 250px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .btn-add {
            background: linear-gradient(to right, #249cff, #a2ffd4);
            color: #fff;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            transition: background 0.4s ease, transform 0.2s ease;
        }

        .btn-add i {
            margin-right: 8px;
        }

        .btn-add:hover {
            background: linear-gradient(45deg, #f0e68c, #ff6b6b);
            transform: scale(1.05);
            text-decoration: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th {
            background-color: rgb(61, 171, 255);
            color: #fff;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }


        td {
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        .icon {
            width: 20px;
            height: 20px;
            margin: 0 5px;
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .icon:hover {
            transform: scale(1.2);
            filter: brightness(1.2);
        }
    </style>
</head>

<body>
    @include('dashboard') <!-- Bao gồm sidebar -->
    <div class="body-wrapper">
        <div class="container">
            <h1>Danh sách danh mục</h1>
            <h2>
                <a href="admin/them-danh-muc" class="btn-add">
                    <i class="fas fa-plus"></i> Thêm danh mục
                </a>
            </h2>
            <table>
                <tr>
                    <th>Mã danh mục</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả danh mục</th>
                    <th>Sửa</th>
                </tr>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->Category_ID }}</td>
                        <td>{{ $item->Category_name }}</td>
                        <td>{{ $item->Category_description }}</td>
                        <td>
                            <a href="thong-tin-danh-muc/{{ $item->Category_ID }}">
                                <img src="{{ asset('img/edit.png') }}" alt="Edit" class="icon">
                            </a>
                            <a href="xoa-danh-muc/{{ $item->Category_ID }}">
                                <img src="{{ asset('img/recycle-bin.png') }}" alt="Delete" class="icon">
                            </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>

</html>
