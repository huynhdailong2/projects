<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Body Styling */
        body {
            background: linear-gradient(to right, #e3f2fd, #bbdefb);
            font-family: 'Arial', sans-serif;
            margin: 0;
        }

        /* Adjusting for Sidebar */
        .body-wrapper {
            margin-left: 280px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Main Container Styling */
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
            margin-top: 100px;
        }

        h1 {
            color: #3f51b5;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Table Styling */
        .table {
            width: 100%;
        }

        /* Form Input Styling */
        .form-control,
        textarea {
            border-radius: 5px;
            border: 1px solid #ccc;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .form-control:focus,
        textarea:focus {
            border-color: #3f51b5;
            box-shadow: 0 0 5px rgba(63, 81, 181, 0.5);
        }

        /* Custom Button Styling */
        .btn-custom {
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s, transform 0.3s;
            cursor: pointer;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
            transform: scale(1.05);
        }

        /* Media Query for Small Screens */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .body-wrapper {
                margin-left: 0;
                /* Xóa margin-left khi trên di động */
            }
        }
    </style>
</head>

<body>
    @include('dashboard')
    <div class="body-wrapper">
        <div class="container mt-5">
            <h1>Thêm danh mục</h1>
            <form action="/admin/them-danh-muc" method="post" class="mt-4">
                @csrf
                <table class="table table-hover">
                    <tr>
                        <td>Tên</td>
                        <td><input type="text" class="form-control" name="txt_name" required></td>
                    </tr>
                    <tr>
                        <td>Mô tả</td>
                        <td>
                            <textarea name="txt_description" class="form-control" rows="4" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center">
                            <button type="submit" class="btn btn-custom">Thêm danh mục</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>

</html>
