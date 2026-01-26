<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt hàng thành công</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:30px 0;">
                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 6px 20px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="background:#16a34a;color:#fff;padding:20px 30px;">
                            <h2 style="margin:0;">ĐẶT HÀNG THÀNH CÔNG</h2>
                            <p style="margin:6px 0 0;font-size:14px;">
                                Mã đơn hàng: <b>#{{ $order->order_id }}</b>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;">
                            <p style="font-size:15px;color:#333;">
                                Xin chào <b>{{ $order?->user->fullname ?? 'Quý khách' }}</b>,
                            </p>

                            <p style="font-size:14px;color:#555;">
                                Cảm ơn bạn đã đặt hàng. Dưới đây là thông tin đơn hàng của bạn:
                            </p>
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="margin:20px 0;font-size:14px;color:#333;">
                                <tr>
                                    <td style="padding:8px 0;">Họ và tên</td>
                                    <td style="padding:8px 0;">
                                        {{ $order?->user->fullname ?? 'N/A' }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">Trạng thái: </td>
                                    <td style="padding:8px 0;">
                                        @if($order->status == \App\Models\PaymentGateway::STATUS_NEW)
                                            Mới đặt
                                        @elseif($order->status == \App\Models\PaymentGateway::STATUS_PENDING)
                                            Đang xử lý
                                        @elseif($order->status == \App\Models\PaymentGateway::STATUS_PAID)
                                            Hoàn thành
                                        @elseif($order->status == \App\Models\PaymentGateway::STATUS_CANCELED)
                                            Đã hủy
                                        @else
                                            $order->status
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">Phương thức thanh toán: </td>
                                    <td style="padding:8px 0;">{{$order?->paymentMethod->name_key}}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">Tình trạng vận chuyển: </td>
                                    <td style="padding:8px 0;">{{$order->shipping}}</td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">Thời gian: </td>
                                    <td style="padding:8px 0;">
                                        {{ $order->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">Địa chỉ: </td>
                                    <td style="padding:8px 0;">
                                        {{ $order->address }}
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:8px 0;">Ghi chú: </td>
                                    <td style="padding:8px 0;">
                                        {{ $order->note ?? 'Không có' }}
                                    </td>
                                </tr>
                            </table>
                            <div style="background:#f0fdf4;border-radius:8px;padding:20px;margin:25px 0;">
                                <table width="100%">
                                    <tr>
                                        <td style="font-size:15px;color:#166534;">
                                            <b>Tổng thanh toán</b>
                                        </td>
                                        <td align="right"
                                            style="font-size:22px;color:#16a34a;font-weight:bold;">
                                            {{ number_format($order->amount ?? 0) }} đ
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f1f5f9;padding:15px;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#64748b;">
                                © {{ date('Y') }} {{ config('app.name') }}. K2025 - Trường Đại Học Công nghệ thông tin. Cảm ơn bạn đã mua sắm!
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>

</html>