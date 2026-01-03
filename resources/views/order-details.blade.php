<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    @include('includes/head')

    <div style="max-width: 1140px; margin: 50px auto;">
        <a href="/cart" style="text-decoration: none; color: #0d6efd; font-size: 16px;">
            <i class="bi bi-arrow-left-circle" style="font-size: 20px; margin-right: 8px;"></i> Trở về
        </a>
       
        <h3 style="margin-top: 30px;">Thông tin đơn hàng</h3>
        @if (session('success'))
        <div style="background-color: #d4edda; border: 1px solid #c3e6cb; padding: 15px; border-radius: 5px; margin-top: 15px; color: #155724;">
            {{ session('success') }}
        </div>
        @endif

        @if ($order)
            <table style="width: 100%; border-collapse: collapse; margin-top: 15px; border: 1px solid #dee2e6;" >
                <thead>
                    <tr style="background-color: #f8f9fa; text-align: left;">
                        <th style="padding: 8px; border: 1px solid #dee2e6;">Hình ảnh</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">Tên sản phẩm</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">Giá</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">Số lượng</th>
                        <th style="padding: 8px; border: 1px solid #dee2e6;">Tổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $item)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">
                                <img src="{{ asset($item->product->Img ?? 'default_image.jpg') }}" alt="{{ $item->product->Name }}" style="max-width: 100px;"/>
                            </td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->product->Name }}</td>
                            <td style="padding: 8px; border: 1px solid #dee2e6; color: #610000;">
                                {{ number_format($item->Price, 0, ',', '.') }} VNĐ
                            </td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">{{ $item->Quantily }}</td>
                            <td style="padding: 8px; border: 1px solid #dee2e6;">{{ number_format($item->Price * $item->Quantily, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Form chọn phương thức thanh toán, phương thức vận chuyển và ghi chú -->
            <form action="{{ route('order.finalize') }}" method="POST" style="margin-top: 20px;">
                @csrf
                
                <!-- Phương thức thanh toán -->
                <div style="margin-bottom: 15px;">
                    <label for="payment_method" style="display: block; font-weight: bold;">Chọn phương thức thanh toán:</label>
                    <select name="payment_method" id="payment_method" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;"  required>
                        <option value="tiền mặt">Thanh toán khi nhận hàng</option>
                        <option value="ngân hàng">Thanh toán online</option>
                    </select>
                </div>

                <!-- Phương thức vận chuyển -->
                <div style="margin-bottom: 15px;">
                    <label for="transport" style="display: block; font-weight: bold;">Chọn phương thức vận chuyển:</label>
                    <select name="transport" id="transport" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px; "  required>
                        <option value="hỏa tốc">Hỏa tốc</option>
                        <option value="giao hàng nhanh">Giao hàng nhanh</option>
                        <option value="tiết kiệm">Tiết kiệm</option>
                    </select>
                </div>
                <div style="margin-bottom: 15px;">
                    <label for="note" style="display: block; font-weight: bold;"> Địa chỉ</label>
                    <input name="address" id="address" placeholder="Nhập địa chỉ" style="border: 1px solid #ced4da ;width: 100%;padding:8px"></textarea>
                </div>
              
                <div style="margin-bottom: 15px;">
                    <label for="note" style="display: block; font-weight: bold;">Ghi chú:</label>
                    <textarea name="note" id="note" style="width: 100%; padding: 8px; border: 1px solid #ced4da; border-radius: 4px;" rows="3" placeholder="Nhập ghi chú cho đơn hàng"></textarea>
                </div>

                <button type="submit" style="background-color: #0d6efd; color: #fff; border: none; padding: 10px 20px; border-radius: 5px;">Gửi</button>
            </form>
            
        @else
            <p style="background-color: #fff3cd; border: 1px solid #ffeeba; padding: 15px; border-radius: 5px; color: #856404;">Không có thông tin đơn hàng!</p>
        @endif
    </div>
</body>
@include('includes/footer') 
</html>
