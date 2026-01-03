<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách sản phẩm</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Reset body margins and paddings */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
        }

        /* Ensure main content respects sidebar width */
        .main-content {
            margin-left: 250px;
            /* Width of the sidebar */
            padding: 20px;
        }

        /* Table container styling */
        .page-container {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 2rem;
            color: #4a4a4a;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-custom {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            /* Gradient màu xanh lam */
            color: #fff;
            /* Màu chữ trắng */
            font-size: 1.2rem;
            /* Tăng kích thước chữ */
            font-weight: bold;
            /* Làm chữ đậm */
            padding: 10px 25px;
            /* Tăng kích thước nút */
            border: none;
            /* Xóa viền */
            border-radius: 25px;
            /* Bo tròn góc nút */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Tạo hiệu ứng đổ bóng */
            transition: all 0.3s ease;
            /* Hiệu ứng mượt */
            cursor: pointer;
            /* Thay đổi con trỏ chuột */
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #00c6fb, #005bea);
            /* Đổi màu khi hover */
            transform: translateY(-3px);
            /* Hiệu ứng nổi lên */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            /* Tăng hiệu ứng bóng */
        }

        /* Table Styling */
        .table th,
        .table td {
            text-align: center;
        }

        .table img {
            width: 70px;
            height: 70px;
            border-radius: 5px;
            object-fit: cover;
        }

        /* Sidebar fixes (if included in dashboard) */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background: #343a40;
            color: #fff;
            z-index: 1000;
        }

        /* Table Styling */
        .table {
            border-collapse: collapse;
            margin: 0 auto;
            /* Center align the table */
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            font-size: 13px;
            /* Consistent font size */
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: center;
            /* Align text to the left for better readability */
            vertical-align: middle;
            /* Vertically center align text */
        }

        .table thead th {
            background-color: #b0fbff;
            font-size: 11px;
            font-weight: bold;
            position: sticky;
            /* Keep header fixed */
            top: 0;
            z-index: 1;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f8f9fa;
            /* Light gray for alternating rows */
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
            /* Light hover effect */
            cursor: pointer;
            /* Pointer cursor on hover */
        }

        /* Responsive images in the table */
        .table img {
            width: 50px;
            /* Adjust size to fit table */
            height: 50px;
            border-radius: 5px;
            object-fit: cover;
        }

        /* Icons Styling */
        .icon {
            width: 20px;
            height: 20px;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .icon:hover {
            transform: scale(1.1);
            /* Slight zoom effect */
            filter: brightness(1.2);
            /* Brighten icon on hover */
        }
    </style>
</head>

<body>
    <!-- Include Dashboard (Assumes it contains the sidebar) -->
    @include('dashboard')

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-container">
            <h1 class="text-center">Danh sách sản phẩm</h1>
            <div class="text-center mb-4">
                <a href="them-san-pham">
                    <button type="button" class="btn btn-custom">Thêm sản phẩm</button>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã SP</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Mô tả</th>
                            <th>Chỉnh sửa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->Product_ID }}</td>
                                <td><img src="{{ asset($item->Img) }}" alt="Product Image"></td>
                                <td>{{ $item->Name }}</td>
                                <td>{{ $item->Category_name }}</td>
                                <td>{{ number_format($item->Price) }} VNĐ</td>
                                <td>{{ $item->Quantily }}</td>
                                <td>{{ $item->Description }}</td>
                                <td>
                                    <a href="thong-tin-san-pham/{{ $item->Product_ID }}">
                                        <img src="{{ asset('img/edit.png') }}" alt="Edit" class="icon"
                                            style="width: 20px;height: 20px">
                                    </a>
                                    <a href="xoa-san-pham/{{ $item->Product_ID }}">
                                        <img src="{{ asset('img/recycle-bin.png') }}" alt="Delete" class="icon"
                                            style="width: 20px;height: 20px">
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
