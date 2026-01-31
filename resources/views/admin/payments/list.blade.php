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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/json-viewer-js@1.0.0/json-viewer.css">
<script src="https://cdn.jsdelivr.net/npm/json-viewer-js@1.0.0/json-viewer.js"></script>


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

        .payment-log {
            background: #0f172a;
            /* dark slate */
            color: #e5e7eb;
            padding: 16px;
            border-radius: 8px;
            max-height: 500px;
            overflow: auto;
            font-size: 13px;
            line-height: 1.6;
            white-space: pre-wrap;
            font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        }

        .payment-log .event {
            color: #38bdf8;
            font-weight: bold;
        }

        .payment-log .request {
            color: #4ade80;
        }

        .payment-log .response {
            color: #facc15;
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
    @include('dashboard')

    <!-- Main Content -->
    <div class="main-content">
        <div class="page-container">
            <h1 class="text-center">Danh sách đặt hàng</h1>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mã giao dịch</th>
                            <th>Số tiền</th>
                            <th>Trạng thái</th>
                            <th>PTTT</th>
                            <th>Order ID</th>
                            <th>Khách hàng</th>
                            <th>Ngày tạo</th>
                            <th>Chi tiết thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->transaction_uuid }}</td>
                            <td>{{ number_format($payment->amount) }} đ</td>
                            <td>{{ $payment->status }}</td>
                            <td>{{ $payment->paymentMethod?->name_key ?? 'N/A' }}</td>
                            <td>
                                {{ $payment->paymentable_id ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $payment->order?->user?->fullname ?? 'N/A' }}
                            </td>

                            <td>{{ $payment->created_at }}</td>
                            <td>
                                <button class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#repuestDataModal"
                                    onclick="loadRequestData({{ $payment->id }})"><i class="bi bi-eye"
                                        style="color: #000000;"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $payments->links() }}

            </div>
        </div>
    </div>

    <!-- Request Data Modal -->
    <div class="modal fade" id="repuestDataModal" tabindex="-1" aria-labelledby="requestDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestDataModalLabel">Request Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <<div id="requestDataContent" class="payment-log"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function loadRequestData(paymentId) {
            fetch(`/admin/payments/${paymentId}/request`)
                .then(res => res.json())
                .then(data => {
                    if (!data.length) {
                        document.getElementById('requestDataContent').textContent = 'No data';
                        return;
                    }

                    let html = '';

                    data.forEach(item => {
                        html += `
                        Event: ${item.event_name}
                        Time : ${item.created_at}
                        Message : ${item.message ?? 'N/A'}
                        Request data : ${JSON.stringify(item.request_data, null, 2)}
                        Response data : ${JSON.stringify(item.response_data, null, 2)}
                        `;
                    });

                    document.getElementById('requestDataContent').textContent = html;
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('requestDataContent').textContent = 'Error loading data';
                });
        }
    </script>

</body>

</html>