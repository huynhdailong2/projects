<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>

    {{-- <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            color: #495057;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 
        }

        h3 {
            color: #bba502;
            font-weight: 600;
            margin-bottom: 30px;
            text-align: center;
        }

        .alert {
            margin-top: 20px;
            padding: 15px;
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-radius: 8px;
        }

        table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse;
            /* Collapse borders to eliminate double borders */
        }

        th,
        td {
            text-align: center;
            vertical-align: middle;
            padding: 15px;
            font-size: 1.1rem;
            border: 1px solid #dee2e6;
            /* Add border to ensure cells are separated */
            border-radius: 8px;
            box-sizing: border-box;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        td img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
        }

        .btn-warning,
        .btn-danger {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .btn-warning {
            background-color: #78ff6f;
            border: none;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .empty-cart-message {
            font-size: 1.2rem;
            color: #6c757d;
            text-align: center;
        }

        .update-quantity-form button {
            font-size: 0.9rem;
            padding: 6px 12px;
            margin-top: 5px;
            border-radius: 5px;
        }

        /* New Styles for Order Table */
        .order-table th,
        .order-table td {
            border: 1px solid #dee2e6;
        }

        .order-table th {
            background-color: #f8f9fa;
        }

        .order-table {
            margin-top: 30px;
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .order-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .order-table tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .order-table th,
        .order-table td {
            padding: 12px;
        }

        /* Optional for finer control of image sizes and form fields */
        input[type="number"] {
            width: 80px;
            height: 30px;
            text-align: center;
        }

        button {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .d-flex.justify-content-between {
            margin-bottom: 30px;
            /* Increase the space between the total and the button */
        }

        /* Ensure the "Cập nhật tất cả" button is well positioned */
        .d-flex button {
            margin-left: 20px;
            /* Adds space between the total price and the button */
        }

        .d-flex h3 {
            font-size: 21px;
            color: rgb(208, 43, 5);
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Adds a subtle shadow */
            padding: 10px;
            border-radius: 5px;
            /* Optional: if you want to round the corners of the shadowed area */
            background-color: #fff;
            /* Optional: add background color to the button */
            display: inline-block;
        }
    </style> --}}
    @include('includes/head')
</head>

<body>

    <div class="container" style="background: #fff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px; max-width: 1000px; margin-top:100px;">
        <a href="/" class="text-decoration-none text-primary" style="font-size: 16px; font-weight: bold; color: #007bff; text-decoration: none;">
            <i class="bi bi-arrow-left-circle" style="font-size: 20px; "></i> Trở về
        </a>
        <h3 style="color: #333; font-size: 24px; margin-bottom: 20px;">Giỏ hàng của bạn</h3>
    
        @if (session('success'))
            <div class="alert alert-success" style="background-color: #d4edda; color: #155724; padding: 10px 15px; border-radius: 4px; margin-bottom: 15px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif
    
        @if (count($cart) > 0)
            <form action="{{ route('cart.updateAll') }}" method="POST">
                @csrf
                <table class="table table-bordered" style="width: 100%; border-collapse: collapse; background: #fff; margin: 20px 0;">
                    <thead>
                        <tr style="background: #f7f7f7; font-weight: bold; color: #555;">
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Hình ảnh</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Tên sản phẩm</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Giá</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Số lượng</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Tổng</th>
                            <th style="padding: 10px; text-align: center; border: 1px solid #ddd;">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart as $id => $item)
                            <tr>
                                <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                    <img src="{{ asset($item['Img'] ?? 'default_image.jpg') }}" alt="{{ $item['Name'] ?? 'Sản phẩm không có tên' }}" style="max-width: 80px; height: auto; border-radius: 5px;" />
                                </td>
                                <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">{{ $item['Name'] ?? 'Tên sản phẩm không xác định' }}</td>
                                <td style="padding: 10px; text-align: center; border: 1px solid #ddd; color: #610000;">
                                    {{ number_format($item['Price'] ?? 0, 0, ',', '.') }} VNĐ
                                </td>
                                <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                    <input type="number" name="cart[{{ $id }}][quantity]" value="{{ $item['quantity'] ?? 1 }}" min="1" style="width: 80px; height: 30px; text-align: center; border: 1px solid #ddd; border-radius: 4px;" />
                                </td>
                                <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                    {{ number_format(($item['Price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }} VNĐ
                                </td>
                                <td style="padding: 10px; text-align: center; border: 1px solid #ddd;">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="font-size: 12px; padding: 5px 10px; background: #ff4d4f; border: none; border-radius: 4px; color: #fff; cursor: pointer;">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
    
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px;">
                    <h3 style="color: rgb(118, 4, 0); font-size: 21px; font-weight: bold;">Tổng cộng: {{ number_format($total, 0, ',', '.') }} VNĐ</h3>
                    <button type="submit" style="font-size: 14px; padding: 8px 15px; background: #ffc107; border: none; border-radius: 5px; color: #333; cursor: pointer;">Cập nhật tất cả</button>
                </div>
            </form>
    
            <form action="{{ route('checkout') }}" method="GET" style="margin-top: 10px;">
                @csrf
                <button type="submit" class="btn btn-warning btn-sm">💳 Thanh toán</button>
            </form>
           
        @else
            <p style="text-align: center; font-size: 18px; color: #888; margin-top: 20px;">Giỏ hàng của bạn đang trống!</p>
        @endif
    </div>
    
    @include('includes/footer')
</body>


</html>
