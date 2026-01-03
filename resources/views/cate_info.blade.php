<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gradient background */
        body {

            font-family: 'Arial', sans-serif;
            margin: 0;
            color: #fff;
        }

        /* Wrapper for compatibility with sidebar */
        .body-wrapper {
            margin-left: 250px;
            /* Đẩy nội dung sang phải để nhường chỗ cho sidebar */
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        /* Container for content */
        .container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
            width: 90%;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            text-align: center;
            font-size: 2.5em;
        }

        /* Table styling */
        .table {
            margin-top: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            /* Đảm bảo các góc của table không vượt ra ngoài radius */
        }

        .table th {
            background: linear-gradient(to right, #4e73df, #1c3e6f);
            color: white;
            padding: 15px;
        }

        .form-control {
            border-radius: 5px;
            /* Nhỏ gọn hơn */
            border: 1px solid #ccc;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 5px rgba(78, 115, 223, 0.5);
        }

        /* Button styling */
        .btn-custom {
            background: linear-gradient(to right, #57ddff, #36a1ff);
            color: white;
            border: none;
            padding: 10px 20px;
            /* Giảm kích thước nút */
            border-radius: 5px;
            /* Nhỏ gọn hơn */
            transition: background 0.3s, transform 0.3s;
            cursor: pointer;
            font-size: 1em;
        }

        .btn-custom:hover {
            background: linear-gradient(to right, #feb47b, #ff7e5f);
            transform: scale(1.05);
        }

        /* Responsive design for smaller screens */
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 2em;
            }
        }
    </style>
</head>

<body>
    @include('dashboard') <!-- Sidebar -->

    <div class="body-wrapper">
        <div class="container">
            <h1>Danh sách danh mục</h1>
            <form action="/cap-nhat-danh-muc" method="post">
                @csrf
                <table class="table table-hover">
                    <tr>
                        <td>ID</td>
                        <td>
                            {{ $item[0]->id }}
                            <input type="hidden" value="{{ $item[0]->Category_ID }}" name="txt_id">
                        </td>
                    </tr>
                    <tr>
                        <td>Tên</td>
                        <td>
                            <input type="text" class="form-control" value="{{ $item[0]->Category_name }}"
                                name="txt_name" required>
                        </td>
                    </tr>
                    <tr>
                        <td>Mô tả</td>
                        <td>
                            <input type="text" class="form-control" value="{{ $item[0]->Category_description }}"
                                name="txt_description" required>
                        </td>
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
