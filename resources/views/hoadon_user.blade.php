<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Danh sách đặt hàng</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .flex-container {
            display: flex;
            gap: 20px;
            /* Khoảng cách giữa các phần tử */
            flex-wrap: wrap;
            /* Đảm bảo các phần tử xuống hàng nếu không đủ không gian */
            margin-bottom: 16px;
            /* Khoảng cách phía dưới */
        }

        .flex-container p {
            margin: 0;
            /* Xóa khoảng cách mặc định của thẻ <p> */
        }


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

        /* Ensure all buttons are the same width and aligned on the same line */
        .d-flex {
            display: flex;
            gap: 10px;
            /* Adjust the gap between the buttons */
            align-items: center;
            /* Vertically center buttons */
        }

        /* Make buttons the same width */
        .d-flex .btn {
            flex: 1;
            /* Ensures all buttons grow to the same width */
        }

        /* Smaller font size for Cập nhật button */
        .d-flex .btn-primary {
            font-size: 9px;
            /* Adjust this value as needed */
        }

        /* Optional: Adjust button height for consistency */
        .d-flex .btn {
            height: 30px;
            /* Adjust to ensure all buttons have the same height */
        }
    </style>
</head>

<body>
    <!-- Include Dashboard (Assumes it contains the sidebar) -->
    @include('includes/head')

    <!-- Main Content -->
    <div class="main-content " style="margin-top: 100px">
        <h2 class="text-center">Đơn hàng của bạn</h2>
        <div class="page-container">

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Ngày tạo đơn</th>
                            <th>Phương Thức Thanh Toán</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái vận chuyển</th>
                            <th>Phương thức vận chuyển</th>
                            <th>Ghi Chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->order_id }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                                @switch($item->payment_method_id)
                                    @case(\App\Models\PaymentMethod::METHOD_PAYPAL)
                                        {{ \App\Models\PaymentMethod::METHOD_PAYPAL_NAME }}
                                        @break

                                    @case(\App\Models\PaymentMethod::METHOD_COD)
                                        {{ \App\Models\PaymentMethod::METHOD_COD_NAME }}
                                        @break

                                    @default
                                        Unknown
                                @endswitch
                            </td>

                            <td>
                                @switch($item->status)
                                    @case('PAID')
                                        Đã thanh toán
                                        @break

                                    @case('PENDING')
                                        Chờ thanh toán
                                        @break

                                    @case('CANCELED')
                                        Đã hủy
                                        @break

                                    @default
                                        Mới đặt hàng
                                @endswitch
                            </td>


                 
                            <td>
                                {{ $item->shipping }}

                            </td>
                      
                            <td>

                                {{ $item->transport }}
                            </td>

                            <td>{{ $item->note }}</td>

                            <!-- Thao tác -->
                            <td>
                                <div class="d-flex gap-2">

                                    <form action="{{ url('huy-don/' . $item->order_id) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Hủy đơn hàng?')">Hủy đơn
                                    </form>

                                    <button class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#orderDetailModal"
                                        onclick="loadOrderDetails({{ $item->order_id }})"><i class="bi bi-eye"
                                            style="color: #000000;"></i></button>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Chi tiết đơn hàng -->
    <div style="margin-top: 100px" class="modal fade" id="orderDetailModal" tabindex="-1"
        aria-labelledby="orderDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailContent">
                    <!-- Nội dung chi tiết đơn hàng sẽ được thêm vào đây -->
                </div>
            </div>
        </div>
    </div>
    @include('includes/footer')
</body>

</html>
<script>
    function loadOrderDetails(order_id) {
        $.get("{{ url('order/details') }}/" + order_id, function(data) {
            if (data.error) {
                alert(data.error);
            } else {
                var content = `
                <div class="flex-container">
        <p><strong>Mã đơn hàng:</strong> ${data.order_id}</p>
        <p><strong>Trạng thái thanh toán:</strong> ${data.payment}</p>
        <p><strong>Địa chỉ:</strong> ${data.address}</p>
        <p><strong>Ghi chú:</strong> ${data.note}</p>
    </div>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID Chi Tiết Đơn Hàng</th>
                                <th>Tên Sản Phẩm</th>
                  
                                <th>Số Lượng</th>
                                <th>Giá</th>
                                <th>Tổng Tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                `;
                data.orderDetails.forEach(function(detail) {
                    content += `
                        <tr>
                            <td>${detail.orderDetail_id}</td>  <!-- Hiển thị đúng trường orderDetail_id -->
                            <td>${detail.product.name}</td>  <!-- Hiển thị đúng tên sản phẩm (Name) -->
                      
                            <td>${detail.Quantily}</td>
                            <td>${detail.Price.toLocaleString('vi-VN')} VNĐ</td>
                            <td>${(detail.Quantily * detail.Price).toLocaleString('vi-VN')} VNĐ</td>
                        </tr>
                    `;
                });
                content += "</tbody></table>";
                // Thêm nội dung vào modal body
                $("#orderDetailContent").html(content);
            }
        });
    }
</script>