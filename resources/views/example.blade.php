<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Nhóm 4 - Quản lý thông tin (IE103)</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<style>
    textarea.font-monospace,
    textarea.font-monospace:focus,
    textarea.font-monospace:hover,
    textarea.font-monospace:active {
        background-color: #000 !important;
        color: #00ff00 !important;
        border-color: #555 !important;
        box-shadow: none !important;
    }

    .auto-resize {
        overflow: hidden;
        resize: none;
        white-space: pre;
    }

    textarea.font-monospace {
        width: 100%;
        white-space: pre;
        /* giữ nguyên format SQL */
        overflow-x: auto;
        /* scroll ngang */
        overflow-y: hidden;
        /* không hiện scroll dọc */
        resize: none;
        /* không resize tay */
        box-sizing: border-box;
    }
</style>

<body class="bg-light">
    <div class="container">
        <a href="https://doan.dyca.vn/" target="_blank" class="btn btn-primary">Về website</a>
    </div>
    <div class="container py-4">
        <div class="row">
            {{-- MENU DỌC --}}
            <div class="col-md-3">
                <div class="list-group" id="verticalTab">
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab','checkout')=='checkout'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-checkout">Luồng xử lý tạo đơn hàng
                    </button>

                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='reportRevenue'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-reportRevenue">
                        Báo cáo doanh thu
                    </button>

                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='reportProduct'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-reportProduct">
                        Báo cáo sản phẩm
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='checkorder'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-checkorder">
                        Kiểm tra đơn hàng
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='reportUser'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-reportUser">
                        Phân loại khách dựa trên tổng tiền đã chi
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='cancelorder'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-cancelorder">
                        Hủy đơn thì trả lại kho
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='inventoryAlert'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-inventoryAlert">
                        Cảnh báo tồn kho
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='hashPassword'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-hashPassword">
                        Mã hóa mật khẩu, kiểm tra mật khẩu
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='promotionUser'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-promotionUser">
                        Giảm giá ngày sinh nhật
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='promotionSpecialDay'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-promotionSpecialDay">
                        Chương trình khuyến mãi theo ngày đặc biệt trong tháng
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='promotionWeekly'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-promotionWeekly">
                        Giảm giá 50% cho sản phẩm nào có tồn trên 300 vào chủ nhật mỗi tuần
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='totalProductPrice'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-totalProductPrice">
                        Tổng tiền sản phẩm gốc trong order_detail
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='totalProductByCategory'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-totalProductByCategory">
                        Tính tổng số lượng sản phẩm dựa theo danh mục
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='monthlyRevenueReport_Cursor'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-monthlyRevenueReport_Cursor">
                        Cursor doanh thu đã thanh toán theo tháng năm dựa trên câu 2 proc
                    </button>
                    <button
                        class="list-group-item list-group-item-action
                {{ session('activeTab')=='Best_selling_products'?'active':'' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#tab-Best_selling_products">
                        Cursor xếp loại sp bán chạy nhất dựa trên câu 4 proc
                    </button>
                </div>
            </div>
            <div class="col-md-9 px-0">
                <div class="tab-content">
                    <div class="tab-pane fade {{ session('activeTab','checkout')=='checkout'?'show active':'' }}"
                        id="tab-checkout">
                        <form action="{{ route('checkout.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    wrap="off"
                                    required>CREATE  PROCEDURE sp_CreateOrder_WithDetail
@user_id INT,
@payment_method_id BIGINT,
@address NVARCHAR(200),
@transport NVARCHAR(100),
@Product_ID INT,
@Quantity INT
AS
BEGIN
    SET NOCOUNT ON;
    IF NOT EXISTS (SELECT 1 FROM users WHERE id = @user_id)
    BEGIN
        RAISERROR(N'User không tồn tại', 16, 1);
        RETURN;
    END
    IF NOT EXISTS (SELECT 1 FROM product WHERE Product_ID = @Product_ID)
    BEGIN
        RAISERROR(N'Sản phẩm không tồn tại', 16, 1);
        RETURN;
    END
    DECLARE @Stock INT;
    DECLARE @Price FLOAT;
    SELECT @Stock = CAST(Quantily AS INT), @Price = Price
    FROM product
    WHERE Product_ID = @Product_ID;
    IF @Quantity > @Stock
    BEGIN
        RAISERROR(N'Số lượng mua vượt quá tồn kho', 16, 1);
        RETURN;
    END
    INSERT INTO orders(user_id, payment_method_id, shipping, transport, status, order_user, address)
    VALUES (@user_id, @payment_method_id, N'Chờ vận chuyển', @transport, 'PENDING', @user_id, @address);
    DECLARE @NewOrderID INT = SCOPE_IDENTITY();
    INSERT INTO order_detail(order_id, Product_ID, Quantily, Price)
    VALUES (@NewOrderID, @Product_ID, @Quantity, @Price);
    UPDATE product
    SET Quantily = CAST(Quantily AS INT) - @Quantity
    WHERE Product_ID = @Product_ID;
    DECLARE @TongTien BIGINT;
    SELECT @TongTien = SUM(od.Quantily * od.Price)
    FROM order_detail od
    WHERE od.order_id = @NewOrderID;
    UPDATE orders
    SET amount = @TongTien
    WHERE order_id = @NewOrderID;
    SELECT 
        o.order_id,
        o.user_id,
        o.status,
        o.shipping,
        o.transport,
        o.address,
        o.amount,
        o.created_at
    FROM orders o
    WHERE o.order_id = @NewOrderID;
END;
GO
EXEC sp_CreateOrder_WithDetail
    @user_id = 16,
    @payment_method_id = 1,
    @address = N'Quận Phú Nhuận',
    @transport = N'Hỏa tốc',
    @Product_ID = 23,
    @Quantity = 3;
</textarea>
                            </div>
                            <label class="form-label fw-semibold">Tham số EXEC (chỉ được sửa số)</label>

                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label fw-semibold">User</label>
                                    <select name="user_id" class="form-control select2" required>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ session('userIdCheckout', 16) == $user->id ? 'selected' : '' }}>
                                            {{ $user->id }} - {{ $user->fullname }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col">
                                    <label class="form-label fw-semibold">Product</label>
                                    <select name="Product_ID" class="form-control select2" required>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->Product_ID }}"
                                            {{ session('productIdCheckout', 23) == $product->Product_ID ? 'selected' : '' }}>
                                            {{ $product->Product_ID }} - {{ $product->Name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label fw-semibold">Payment Method</label>
                                    <select name="payment_method_id" class="form-control select2" required>
                                        @foreach ($paymentGetways as $paymentGetway)
                                        <option value="{{ $paymentGetway->id }}"
                                            {{ session('paymentMethodIdCheckout', 1) == $paymentGetway->id ? 'selected' : '' }}>
                                            {{ $paymentGetway->id }} - {{ $paymentGetway->name_key }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label fw-semibold">Quantity</label>
                                    <input type="number" name="Quantity" class="form-control" placeholder="@Quantity" required value="{{ session('quantityCheckout', 3) }}">
                                </div>
                                <div class="col">
                                    <label class="form-label fw-semibold">Transport</label>
                                    <input type="text" name="transport" class="form-control" placeholder="@transport" required value="{{ session('transportCheckout', 'Hỏa tốc') }}">
                                </div>
                            </div>

                            <div class="mt-2">
                                <label class="form-label fw-semibold">Address</label>
                                <input type="text" name="address" class="form-control"
                                    placeholder="@address" required value="{{ session('addressCheckout', 'Quận Phú Nhuận') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">storeCheckout</button>
                        </form>
                        <hr>
                        <div id="result-storeUser">

                            <table border="1" cellpadding="9" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>PTTT</th>
                                        <th>Số tiền</th>
                                        <th>Trang thái</th>
                                        <th>shipping</th>
                                        <th>transport</th>
                                        <th>order_user</th>
                                        <th>Địa chỉ</th>
                                        <th>Ghi chú</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th>Chi tiết đơn hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orderCheckouts as $item)
                                    <tr>
                                        <td>{{ $item->order_id }}</td>
                                        <td>{{ $item->user_id }} - {{ $item->user_fullname }}</td>
                                        <td>{{ $item->payment_method_id }} - {{ $item->payment_method_name }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->shipping }}</td>
                                        <td>{{ $item->transport }}</td>
                                        <td>{{ $item->order_user }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <p>- Tên SP: {{ $item->product_name }} </p>
                                            <p>- Số lượng: {{ $item->order_quantity }} / {{ $item->product_quantity }}</p>
                                            <p>- Giá: {{ $item->product_price }}</p>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='reportRevenue'?'show active':'' }}"
                        id="tab-reportRevenue">
                        <form action="{{ route('report.revenue') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf

                            <div class="mb-3">
                                <textarea
                                    wrap="off"
                                    class="form-control font-monospace auto-resize"
                                    readonly>CREATE PROCEDURE sp_MonthlyRevenueReport
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (SELECT 1 FROM orders)
    BEGIN
        PRINT N'Chưa có dữ liệu đơn hàng';
        RETURN;
    END

    SELECT 
        YEAR(created_at) AS Nam,
        MONTH(created_at) AS Thang,
        COUNT(order_id) AS SoLuongDon,
        SUM(amount) AS TongDoanhThu,
        AVG(amount) AS TrungBinhMoiDon
    FROM orders
    WHERE status = 'PAID'
    GROUP BY YEAR(created_at), MONTH(created_at)
    ORDER BY Nam DESC, Thang DESC;
END;

EXEC sp_MonthlyRevenueReport;
        </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                reportRevenue
                            </button>
                        </form>

                        <hr>
                        <div id="result-reportRevenue">

                            @if(session('revuneReports'))
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Năm</th>
                                        <th>Tháng</th>
                                        <th>Số lượng đơn</th>
                                        <th>Tổng doanh thu</th>
                                        <th>Trung bình / đơn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('revuneReports') as $item)
                                    <tr>
                                        <td>{{ $item->Nam }}</td>
                                        <td>{{ $item->Thang }}</td>
                                        <td>{{ $item->SoLuongDon }}</td>
                                        <td>{{ number_format($item->TongDoanhThu) }}</td>
                                        <td>{{ number_format($item->TrungBinhMoiDon) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='reportProduct'?'show active':'' }}"
                        id="tab-reportProduct">

                        <form action="{{ route('product.report') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold"> SQL SERVER:
                                </label>
                                <textarea
                                    wrap="off"
                                    class="form-control font-monospace auto-resize"
                                    readonly>CREATE PROCEDURE sp_TopSellingProducts
    @MinSold INT = 1
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (SELECT 1 FROM order_detail)
    BEGIN
        PRINT N'Chưa có dữ liệu bán hàng';
        RETURN;
    END

    SELECT 
        p.Product_ID,
        p.Name,
        p.Price,
        CAST(p.Quantily AS INT) AS TonKho,
        SUM(od.Quantily) AS TongSoLuongDaBan,

        CASE 
            WHEN SUM(od.Quantily) >= 10 THEN N'Bán chạy'
            WHEN SUM(od.Quantily) >= 5 THEN N'Bán khá'
            ELSE N'Bán ít'
        END AS MucDoBan,

        CASE 
            WHEN CAST(p.Quantily AS INT) < 10 THEN N'Tồn kho thấp'
            ELSE N'Bình thường'
        END AS TrangThaiKho

    FROM product p
    JOIN order_detail od 
        ON p.Product_ID = od.Product_ID

    GROUP BY 
        p.Product_ID, 
        p.Name, 
        p.Price, 
        p.Quantily

    HAVING SUM(od.Quantily) >= @MinSold
    ORDER BY TongSoLuongDaBan DESC;
END;

EXEC sp_TopSellingProducts;
EXEC sp_TopSellingProducts @MinSold = 5;
        </textarea>
                            </div>

                            <label class="form-label fw-semibold">Tham số EXEC (chỉ được sửa số)</label>

                            <div class="row g-2 mb-3">
                                <div class="col-3">
                                    <input
                                        type="number"
                                        name="min_sold"
                                        class="form-control"
                                        placeholder="@MinSold"
                                        value="{{ session('minSold', 1) }}"
                                        min="1"
                                        required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                sp_TopSellingProducts
                            </button>
                        </form>
                        <hr>
                        <div id="result-reportProduct">

                            @if(session('reports'))
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Tồn kho</th>
                                        <th>Đã bán</th>
                                        <th>Mức độ bán</th>
                                        <th>Trạng thái kho</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('reports') as $item)
                                    <tr>
                                        <td>{{ $item->Product_ID }}</td>
                                        <td>{{ $item->Name }}</td>
                                        <td>{{ number_format($item->Price) }}</td>
                                        <td>{{ $item->TonKho }}</td>
                                        <td>{{ $item->TongSoLuongDaBan }}</td>
                                        <td>
                                            <span class="badge 
                    @if($item->MucDoBan === 'Bán chạy') bg-success
                    @elseif($item->MucDoBan === 'Bán khá') bg-warning
                    @else bg-secondary
                    @endif">
                                                {{ $item->MucDoBan }}
                                            </span>
                                        </td>
                                        <td>{{ $item->TrangThaiKho }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>

                    <div class="tab-pane fade {{ session('activeTab')=='checkorder'?'show active':'' }}"
                        id="tab-checkorder">

                        <form action="{{ route('order.check') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold"> SQL SERVER:
                                </label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE PROCEDURE sp_CheckOrder
    @HighAmount FLOAT = 50
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (SELECT 1 FROM orders)
    BEGIN
        PRINT N'Chưa có dữ liệu đơn hàng';
        RETURN;
    END

    SELECT 
        o.order_id,
        u.fullname AS TenKhachHang,
        o.amount AS GiaTriDonHang,
        o.status,
        o.created_at,

        CASE 
            WHEN o.amount >= @HighAmount THEN N'Đơn giá trị cao'
            WHEN o.status = 'CANCELED' THEN N'Đơn bị hủy'
            WHEN EXISTS (
                SELECT 1 FROM orders o2 
                WHERE o2.user_id = o.user_id 
                  AND TIMESTAMPDIFF(MINUTE, o2.created_at, o.created_at) <= 10
                  AND o2.order_id <> o.order_id
            ) THEN N'Nhiều đơn trong thời gian ngắn'
            ELSE N'Bình thường'
        END AS LyDoCanhBao

    FROM orders o
    JOIN users u ON o.user_id = u.id
    WHERE o.amount IS NOT NULL
      AND (o.amount >= @HighAmount OR o.status = 'CANCELED')
    ORDER BY o.created_at DESC;
END;

EXEC sp_CheckOrder @HighAmount = 30;
        </textarea>
                            </div>

                            <label class="form-label fw-semibold">Tham số EXEC (chỉ được sửa số)</label>

                            <div class="row g-2 mb-3">
                                <div class="col-3">
                                    <input
                                        type="number"
                                        name="high_amount"
                                        class="form-control"
                                        placeholder="@HighAmount"
                                        value="{{ session('highAmount', 10) }}"
                                        min="1"
                                        required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                checkOrder
                            </button>
                        </form>

                        <hr>
                        <div id="result-reportProduct">

                            @if(session('checkOrders'))
                            <table class="table table-bordered table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Giá trị đơn</th>
                                        <th>Trạng thái</th>
                                        <th>Thời gian</th>
                                        <th>Lý do cảnh báo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('checkOrders') as $o)
                                    <tr>
                                        <td>{{ $o->order_id }}</td>
                                        <td>{{ $o->TenKhachHang }}</td>
                                        <td>{{ number_format($o->GiaTriDonHang) }}</td>
                                        <td>
                                            <span class="badge 
                    @if($o->status === 'CANCELED') bg-danger
                    @else bg-info
                    @endif">
                                                {{ $o->status }}
                                            </span>
                                        </td>
                                        <td>{{ $o->created_at }}</td>
                                        <td>
                                            <span class="badge 
                    @if($o->LyDoCanhBao === 'Đơn giá trị cao') bg-warning
                    @elseif($o->LyDoCanhBao === 'Nhiều đơn trong thời gian ngắn') bg-danger
                    @else bg-secondary
                    @endif">
                                                {{ $o->LyDoCanhBao }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có đơn hàng nào</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='reportUser'?'show active':'' }}"
                        id="tab-reportUser">

                        <form action="{{ route('user.reportVip') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE PROCEDURE sp_VIPCustomerRanking
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (SELECT 1 FROM orders)
    BEGIN
        PRINT N'Chưa có dữ liệu đơn hàng';
        RETURN;
    END

    SELECT 
        u.id AS UserID,
        u.fullname AS TenKhachHang,
        COUNT(o.order_id) AS TongSoDonHang,
        SUM(o.amount) AS TongTienDaChi,
        MAX(o.created_at) AS LanMuaGanNhat,

        CASE 
            WHEN SUM(o.amount) >= 100 THEN N'Khách VIP'
            WHEN SUM(o.amount) >= 50 THEN N'Khách tiềm năng'
            ELSE N'Khách thường'
        END AS HangKhachVIP

    FROM users u
    LEFT JOIN orders o ON u.id = o.user_id
    GROUP BY u.id, u.fullname
    ORDER BY TongTienDaChi DESC;
END;

EXEC sp_VIPCustomerRanking;
        </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                reportVIPCustomer
                            </button>
                        </form>
                        <hr>
                        <div id="result-reportVipCustomer">
                            @if(session('vipCustomers'))
                            <table class="table table-bordered table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Tên khách hàng</th>
                                        <th>Tổng số đơn</th>
                                        <th>Tổng tiền đã chi</th>
                                        <th>Lần mua gần nhất</th>
                                        <th>Hạng khách hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('vipCustomers') as $u)
                                    <tr>
                                        <td>{{ $u->UserID }}</td>
                                        <td>{{ $u->TenKhachHang }}</td>
                                        <td>{{ $u->TongSoDonHang }}</td>
                                        <td>{{ number_format($u->TongTienDaChi) }}</td>
                                        <td>{{ $u->LanMuaGanNhat ?? 'Chưa mua' }}</td>
                                        <td>
                                            <span class="badge
                    @if($u->HangKhachVIP === 'Khách VIP') bg-success
                    @elseif($u->HangKhachVIP === 'Khách tiềm năng') bg-warning
                    @else bg-secondary
                    @endif">
                                                {{ $u->HangKhachVIP }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='cancelorder'?'show active':'' }}"
                        id="tab-cancelorder">

                        <form action="{{ route('order.cancel') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE TRIGGER tr_RestoreStock
ON orders
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (
        SELECT 1
        FROM inserted i
        JOIN deleted d ON i.order_id = d.order_id
        WHERE i.status = 'CANCELED' AND d.status <> 'CANCELED'
    )
        RETURN;

    UPDATE p
    SET p.Quantily = CAST(p.Quantily AS INT) + od.Quantily
    FROM product p
    JOIN order_detail od 
        ON p.Product_ID = od.Product_ID
    JOIN inserted i 
        ON od.order_id = i.order_id
    JOIN deleted d 
        ON i.order_id = d.order_id
    WHERE i.status = 'CANCELED'
      AND d.status <> 'CANCELED';

    SELECT 
        p.Product_ID,
        p.Name,
        CAST(p.Quantily AS INT) AS TonKhoSauHoan,
        od.Quantily AS SoLuongHoan,
        GETDATE() AS ThoiGianHoanKho,
        N'HOÀN KHO THÀNH CÔNG' AS ThongBao
    FROM product p
    JOIN order_detail od 
        ON p.Product_ID = od.Product_ID
    JOIN inserted i 
        ON od.order_id = i.order_id
    WHERE i.status = 'CANCELED';
END;

SELECT Product_ID, Quantily FROM product WHERE Product_ID = 24;
UPDATE orders
SET status = 'CANCELED'
WHERE order_id = 1096;

        </textarea>
                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label fw-semibold">Đơn hàng</label>
                                    <select name="order_id" class="form-control select2" required>
                                        @foreach ($orders as $order)
                                        <option value="{{ $order->order_id }}"
                                            {{ session('orderIdCancel') == $order->order_id ? 'selected' : '' }}>
                                            #{{ $order->order_id }} — {{ $order->status }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                cancelOrder
                            </button>
                        </form>
                        <hr>
                        <div id="result-cancelOrders">
                            @if(session('cancelOrders'))
                            <table class="table table-bordered table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng hoàn</th>
                                        <th>Tồn kho sau hoàn</th>
                                        <th>Thời gian hoàn</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('cancelOrders') as $item)
                                    <tr>
                                        <td>{{ $item->Product_ID }}</td>
                                        <td>{{ $item->Product_Name }}</td>
                                        <td>{{ $item->SoLuongHoan }}</td>
                                        <td>{{ $item->TonKhoSauHoan }}</td>
                                        <td>{{ $item->ThoiGianHoanKho }}</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $item->ThongBao }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='inventoryAlert'?'show active':'' }}"
                        id="tab-inventoryAlert">

                        <form action="{{ route('inventory.alert') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE TRIGGER tr_StockWarning
ON product
AFTER UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    IF NOT EXISTS (
        SELECT 1
        FROM inserted i
        JOIN deleted d ON i.Product_ID = d.Product_ID
        WHERE CAST(i.Quantily AS INT) <> CAST(d.Quantily AS INT)
          AND CAST(i.Quantily AS INT) <= 10
    )
        RETURN;

    SELECT
        i.Product_ID,
        i.Name,
        CAST(i.Quantily AS INT) AS TonKhoHienTai,
        N'RẤT THẤP' AS MucDoCanhBao,
        GETDATE() AS ThoiGianCanhBao,
        N'CẢNH BÁO TỒN KHO THẤP' AS ThongBao
    FROM inserted i
    WHERE CAST(i.Quantily AS INT) <= 10;
END;

        </textarea>
                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label fw-semibold">Đơn hàng</label>
                                    <input type="number"
                                        name="threshold"
                                        class="form-control"
                                        min="1"
                                        value="{{ old('threshold', 10) }}"
                                        required>
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary">
                                inventoryAlert
                            </button>
                        </form>
                        <hr>
                        <hr>

                        <div id="result-inventory-alert">
                            @if(session('inventoryAlerts'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-danger">
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Tồn kho</th>
                                        <th>Mức cảnh báo</th>
                                        <th>Thời gian</th>
                                        <th>Thông báo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(session('inventoryAlerts') as $p)
                                    <tr>
                                        <td>{{ $p->Product_ID }}</td>
                                        <td>{{ $p->Name }}</td>
                                        <td class="fw-bold text-danger">{{ $p->TonKhoHienTai }}</td>
                                        <td><span class="badge bg-danger">{{ $p->MucDoCanhBao }}</span></td>
                                        <td>{{ $p->ThoiGianCanhBao }}</td>
                                        <td>{{ $p->ThongBao }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @endif
                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='hashPassword'?'show active':'' }}"
                        id="tab-hashPassword">

                        <form action="{{ route('check.password') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE TRIGGER tr_Password_Users
ON users
AFTER INSERT, UPDATE
AS
BEGIN
    SET NOCOUNT ON;
    IF EXISTS (
        SELECT 1
        FROM inserted i
        WHERE i.password IS NULL OR LEN(i.password) = 0
    )
    BEGIN
        RAISERROR (N'Mật khẩu không được để trống', 16, 1);
        ROLLBACK TRANSACTION;
        RETURN;
    END
    IF EXISTS (
        SELECT 1
        FROM inserted i
        WHERE 
            LEN(i.password) < 6
            OR i.password NOT LIKE '%[A-Z]%'
            OR i.password NOT LIKE '%[a-z]%'
            OR i.password NOT LIKE '%[0-9]%'
            OR i.password NOT LIKE '%[^a-zA-Z0-9]%'
    )
    BEGIN
        RAISERROR (
            N'Mật khẩu phải có chữ hoa, chữ thường, số và ký tự đặc biệt',
            16, 1
        );
        ROLLBACK TRANSACTION;
        RETURN;
    END
    IF EXISTS (
        SELECT 1
        FROM inserted i
        WHERE LOWER(i.password) LIKE '%' + LOWER(i.username) + '%'
    )
    BEGIN
        RAISERROR (
            N'Mật khẩu không được chứa username',
            16, 1
        );
        ROLLBACK TRANSACTION;
        RETURN;
    END
    UPDATE u
    SET u.password = CONVERT(
        VARCHAR(255),
        HASHBYTES('SHA2_256', i.password),
        2
    )
    FROM users u
    JOIN inserted i ON u.id = i.id
    WHERE LEN(i.password) < 100;
END;
GO
INSERT INTO users (username, fullname, password)
VALUES (N'dat', N'Nguyễn Đạt', N'DAT@123');
        </textarea>
                            </div>
                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ session('usernameCheck', 'dat') }}" required>
                                </div>

                                <div class="col">
                                    <label class="form-label fw-semibold">Fullname</label>
                                    <input type="text" name="fullname" class="form-control"
                                        value="{{ session('fullnameCheck', 'Nguyễn Đạt') }}" required>
                                </div>

                                <div class="col">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="text" name="password" class="form-control"
                                        value="{{ session('passwordCheck', 'Dat123?') }}" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                storeUser
                            </button>
                        </form>
                        <hr>
                        <div id="result-inventory-alert">
                            @if(session('userCheck'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ session('userCheck')->id }}</td>
                                        <td>{{ session('userCheck')->username }}</td>
                                        <td>{{ session('userCheck')->fullname }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='promotionUser'?'show active':'' }}"
                        id="tab-promotionUser">

                        <form action="{{ route('user.birthdayDiscount') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE TRIGGER tr_BirthdayDiscount
ON order_detail
AFTER INSERT
AS
BEGIN
    SET NOCOUNT ON;

DECLARE @order_id INT;
DECLARE @user_id INT;
DECLARE @total BIGINT;
DECLARE @birthday NVARCHAR(100);

    SELECT @order_id = order_id FROM inserted;

    SELECT @user_id = user_id
    FROM orders
    WHERE order_id = @order_id;

    SELECT @birthday = birthday
    FROM profile
    WHERE user_id = @user_id;

    SELECT @total = SUM(Quantily * Price)
    FROM order_detail
    WHERE order_id = @order_id;

    UPDATE orders  SET amount = @total
    WHERE order_id = @order_id;

    IF @birthday IS NOT NULL 
       AND CONVERT(date, @birthday) = CONVERT(date, GETDATE())
    BEGIN
        IF @order_id = (
            SELECT MIN(order_id)
            FROM orders
            WHERE user_id = @user_id
              AND CONVERT(date, created_at) = CONVERT(date, GETDATE())
        )
			BEGIN
				IF @total > 60
					UPDATE orders 
					SET amount = @total - (@total * 0.5)
					WHERE order_id = @order_id;

				ELSE IF @total > 40
					UPDATE orders 
					SET amount = @total - (@total * 0.25)
					WHERE order_id = @order_id;
			END
	END

    SELECT 
        o.order_id,
        @total AS TongTruocGiam,
        o.amount AS TongSauGiam
    FROM orders o
    WHERE o.order_id = @order_id;
END;
GO


UPDATE profile SET birthday = CONVERT(VARCHAR(10), GETDATE(), 120)
WHERE user_id = 1011;

INSERT INTO orders(user_id, payment_method_id, shipping, status, order_user, address)
VALUES (1011, 2, N'Chờ vận chuyển', N'PENDING', 11, N'Q2');
INSERT INTO order_detail(order_id, Product_ID, Quantily, Price)
VALUES (1120, 20, 4, 20);
INSERT INTO orders(user_id, payment_method_id, shipping, status, order_user, address)
VALUES (1011, 1, N'Đang xử lí', N'PAID', 11, N'Q2');
INSERT INTO order_detail(order_id, Product_ID, Quantily, Price)
VALUES (1121, 18, 4, 15);

        </textarea>
                            </div>
                            <div class="row g-2 mb-3">

                                <div class="col">
                                    <label class="form-label fw-semibold">User</label>
                                    <select name="user_id" class="form-control select2" required>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ session('userIdDiscount', 16) == $user->id ? 'selected' : '' }}>
                                            {{ $user->id }} - {{ $user->fullname }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col">
                                    <label class="form-label fw-semibold">Product</label>
                                    <select name="product_id" class="form-control select2" required>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->Product_ID }}"
                                            {{ session('productIdDiscount') == $product->Product_ID ? 'selected' : '' }}>
                                            {{ $product->Product_ID }} - {{ $product->Name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label class="form-label fw-semibold">Order</label>
                                    <select name="order_id" class="form-control select2" required>
                                        @foreach ($orders as $order)
                                        <option value="{{ $order->order_id }}"
                                            {{ session('orderIdDiscount') == $order->order_id ? 'selected' : '' }}>
                                            #{{ $order->order_id }} — {{ $order->status }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row g-2 mb-3">
                                <div class="col">
                                    <label class="form-label fw-semibold">Birthday</label>
                                    <input type="date" name="birthday" class="form-control"
                                        value="{{ session('birthdayDiscount', now()->toDateString()) }}" required>
                                </div>
                                <div class="col">
                                    <label class="form-label fw-semibold">Quantity</label>
                                    <input type="number" name="quantity" class="form-control"
                                        value="{{session('quantityDiscount', 4) }}" required>
                                </div>

                                <div class="col">
                                    <label class="form-label fw-semibold">Price</label>
                                    <input type="number" name="price" class="form-control"
                                        value="{{ session('priceDiscount', 16) }}" required>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary">
                                tr_BirthdayDiscount
                            </button>
                        </form>
                        <hr>
                        <div id="result-discountResult">

                            @if(session('discountResult'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Order ID</th>
                                        <th>Amount (Sau giảm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ session('discountResult')->user_id }}</td>
                                        <td>{{ session('discountResult')->username }}</td>
                                        <td>{{ session('discountResult')->fullname }}</td>
                                        <td>{{ session('discountResult')->order_id }}</td>
                                        <td>{{ number_format(session('discountResult')->amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='promotionSpecialDay'?'show active':'' }}"
                        id="tab-promotionSpecialDay">

                        <form action="{{ route('user.promotionSpecialDay') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
create TRIGGER tr_Discount_Sale
ON order_detail
AFTER INSERT
AS
BEGIN
    SET NOCOUNT ON;

DECLARE @Today DATE = '2026-02-02';
DECLARE @Day INT = DAY(@Today);
DECLARE @Month INT = MONTH(@Today);

    IF (@Day = 1 OR @Day = 15 OR @Day = @Month)
    BEGIN
        IF (@Day = @Month)
        BEGIN
            INSERT INTO order_detail (order_id, Product_ID, Quantily, Price)
            SELECT i.order_id, 29, 1,0 FROM inserted i
				WHERE NOT EXISTS (
					SELECT 1 
					FROM order_detail od 
					WHERE od.order_id = i.order_id 
					  AND od.Product_ID = 29)
            AND (
                SELECT SUM(od.Quantily)
                FROM order_detail od
                WHERE od.order_id = i.order_id
                  AND od.Product_ID <> 29
                ) >= 3;   
        END

            UPDATE o SET o.amount = ( SELECT SUM(  od.Quantily *
					CASE 
						WHEN p.cate_id = 4 THEN od.Price - (od.Price * 0.20)
						WHEN p.cate_id = 5 THEN od.Price - (od.Price * 0.25)
						ELSE od.Price
					END )
            FROM order_detail od
            JOIN product p ON od.Product_ID = p.Product_ID
            WHERE od.order_id = o.order_id
              AND od.Product_ID <> 29  )
        FROM orders o
        WHERE o.order_id IN (SELECT order_id FROM inserted);

        SELECT 
            od.order_id,
            p.Name AS TenSanPham,
            p.cate_id,
            od.Quantily,
            od.Price AS GiaGoc,

		od.Quantily *
            CASE 
                WHEN p.cate_id = 4 THEN od.Price - (od.Price * 0.20)
                WHEN p.cate_id = 5 THEN od.Price - (od.Price * 0.25)
                ELSE od.Price
            END AS ThanhTienSauGiam,

        qua.Name AS TenSanPhamDuocTang

        FROM order_detail od
        JOIN product p 
            ON od.Product_ID = p.Product_ID
        LEFT JOIN product qua 
            ON qua.Product_ID = 29
        WHERE od.order_id IN (SELECT order_id FROM inserted)
	    AND od.Product_ID <> 29;  
    END
END;
GO
-- thêm đơn hàng, quan sát amount có thay đổi sau khi mua 3 được giảm theo category ko
INSERT INTO orders(user_id, payment_method_id, shipping, status, order_user, address)
VALUES (49, 1, N'Đã giao', N'PAID', 49, N'q7');

----thêm sản phẩm, nếu mà mua >= 3 thì sẽ được tặng sp có product_id=29
INSERT INTO order_detail(order_id, Product_ID, Quantily, Price)
VALUES (48, 17, 3, 20);

        </textarea>
                            </div>
                            <div class="row g-2 mb-3">

                                {{-- ORDER --}}
                                <div class="col">
                                    <label class="form-label fw-semibold">Order</label>
                                    <select name="order_id" class="form-control select2" required>
                                        @foreach ($orders as $order)
                                        <option value="{{ $order->order_id }}"
                                            {{ session('orderIdSpecialDay') == $order->order_id ? 'selected' : '' }}>
                                            #{{ $order->order_id }} — {{ $order->status }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- PRODUCT --}}
                                <div class="col">
                                    <label class="form-label fw-semibold">Product</label>
                                    <select name="product_id" class="form-control select2" required>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->Product_ID }}"
                                            {{ session('productIdSpecialDay') == $product->Product_ID ? 'selected' : '' }}>
                                            {{ $product->Product_ID }} - {{ $product->Name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="row g-2 mb-3">

                                {{-- QUANTITY --}}
                                <div class="col">
                                    <label class="form-label fw-semibold">Quantity</label>
                                    <input type="number"
                                        name="quantity"
                                        class="form-control"
                                        min="1"
                                        value="{{ session('quantitySpecialDay', 3) }}"
                                        required>
                                    <small class="text-muted">
                                        ≥ 3 sẽ kích hoạt mua 3 tặng 1 (nếu là ngày sale)
                                    </small>
                                </div>

                                {{-- PRICE --}}
                                <div class="col">
                                    <label class="form-label fw-semibold">Price</label>
                                    <input type="number"
                                        name="price"
                                        class="form-control"
                                        min="0"
                                        value="{{ session('priceSpecialDay', 20) }}"
                                        required>
                                </div>

                            </div>


                            <button type="submit" class="btn btn-primary">
                                tr_SpecialDayDiscount
                            </button>
                        </form>
                        <hr>
                        <div id="result-promotionSpecialDayResult">

                            @if(session('promotionSpecialDayResult'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>User ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                        <th>Order ID</th>
                                        <th>Amount (Sau giảm)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ session('promotionSpecialDayResult')->user_id }}</td>
                                        <td>{{ session('promotionSpecialDayResult')->username }}</td>
                                        <td>{{ session('promotionSpecialDayResult')->fullname }}</td>
                                        <td>{{ session('promotionSpecialDayResult')->order_id }}</td>
                                        <td>{{ number_format(session('promotionSpecialDayResult')->amount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif

                        </div>

                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='promotionWeekly'?'show active':'' }}"
                        id="tab-promotionWeekly">

                        <form action="{{ route('user.promotionWeekly') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
create FUNCTION dbo.fn_WeekendStockDiscount
(
@Product_ID INT,
@Price DECIMAL(18,2),
@Date DATETIME
)
RETURNS DECIMAL(18,2)
AS
BEGIN
    DECLARE @Stock INT;

    SELECT @Stock = CAST(Quantily AS INT)
    FROM product
    WHERE Product_ID = @Product_ID;

    IF @Stock > 300 
       AND DATENAME(WEEKDAY, @Date) = N'Sunday'
    BEGIN
        RETURN @Price * 0.5; 
    END

    RETURN @Price;
END;
GO

--kiểm tra chủ nhật thì giảm 50% còn ngày thường thì ko
SELECT 
    dbo.fn_WeekendStockDiscount(21, 24, '2026-01-25') AS GiaChuNhat,
    dbo.fn_WeekendStockDiscount(21, 24, '2026-01-26') AS GiaNgayThuong;

áp dụng: sử dụng function trong procedure, dùng ngày giả định hôm nay là chủ nhật để giảm giá(tham số truyền vào)
create PROCEDURE sp_WeekendStockDiscount
(
@TestDate DATETIME
)
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (SELECT 1 FROM order_detail)
    BEGIN
        PRINT N'Chưa có dữ liệu bán hàng';
        RETURN;
    END

    SELECT 
        o.order_id, @TestDate AS NgayTest,

        p.Product_ID,
        p.Name AS TenSanPham,
        CAST(p.Quantily AS INT) AS TonKho,

        od.Quantily AS SoLuongMua,
        od.Price AS GiaGoc,

        dbo.fn_WeekendStockDiscount(
            p.Product_ID,
            od.Price,
            @TestDate ) AS GiaSauGiam,

        od.Price - dbo.fn_WeekendStockDiscount(
            p.Product_ID,
            od.Price,
            @TestDate  ) AS GiamTren1SanPham,

        od.Quantily * od.Price AS ThanhTienGiaGoc,

        od.Quantily * dbo.fn_WeekendStockDiscount
		(   p.Product_ID,
            od.Price,
            @TestDate ) AS ThanhTienSauGiam,

        (od.Quantily * od.Price) - (od.Quantily * dbo.fn_WeekendStockDiscount(
            p.Product_ID,
            od.Price,
            @TestDate )) AS TongTienGiam,

        CASE 
            WHEN od.Price = dbo.fn_WeekendStockDiscount(
                p.Product_ID, od.Price, @TestDate
            )
            THEN N'Không giảm'
            ELSE N'Giảm Chủ Nhật do tồn kho cao'
        END AS LyDoGiam

    FROM order_detail od
    JOIN orders o 
        ON od.order_id = o.order_id
    JOIN product p 
        ON od.Product_ID = p.Product_ID

    ORDER BY TongTienGiam DESC;
END;
GO

EXEC sp_WeekendStockDiscount '2026-01-25';


        </textarea>
                            </div>
                            <div class="row g-2 mb-3">

                                <div class="col-3">
                                    <label class="form-label fw-semibold">Ngày kiểm tra (TestDate)</label>
                                    <input type="date"
                                        name="test_date"
                                        class="form-control"
                                        value="{{ session('testDateWeekly', '2026-01-25') }}"
                                        required>
                                    <small class="text-muted">
                                        Chủ nhật + tồn kho 300 → giảm 50%
                                    </small>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">
                                sp_WeekendStockDiscount
                            </button>
                        </form>
                        <hr>
                        <div id="result-WeekendStockDiscount">

                            @if(session('weeklyPromotionResults'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Ngày test</th>
                                        <th>Product ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Tồn kho</th>
                                        <th>Số lượng mua</th>
                                        <th>Giá gốc</th>
                                        <th>Giá sau giảm</th>
                                        <th>Giảm / 1 SP</th>
                                        <th>Thành tiền gốc</th>
                                        <th>Thành tiền sau giảm</th>
                                        <th>Tổng tiền giảm</th>
                                        <th>Lý do giảm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('weeklyPromotionResults') as $item)
                                    <tr>
                                        <td>{{ $item->order_id }}</td>
                                        <td>{{ $item->NgayTest }}</td>
                                        <td>{{ $item->Product_ID }}</td>
                                        <td>{{ $item->TenSanPham }}</td>
                                        <td>{{ $item->TonKho }}</td>
                                        <td>{{ $item->SoLuongMua }}</td>
                                        <td>{{ number_format($item->GiaGoc) }}</td>
                                        <td>{{ number_format($item->GiaSauGiam) }}</td>
                                        <td>{{ number_format($item->GiamTren1SanPham) }}</td>
                                        <td>{{ number_format($item->ThanhTienGiaGoc) }}</td>
                                        <td>{{ number_format($item->ThanhTienSauGiam) }}</td>
                                        <td>{{ number_format($item->TongTienGiam) }}</td>
                                        <td>{{ $item->LyDoGiam }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="13" class="text-center">
                                            Không có dữ liệu
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif

                        </div>

                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='totalProductPrice'?'show active':'' }}"
                        id="tab-totalProductPrice">

                        <form action="{{ route('user.totalProductPrice') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE FUNCTION dbo.fn_TinhTongTienDonHang(@order_id INT)
RETURNS FLOAT
AS
BEGIN
    DECLARE @TongTien FLOAT;
    
    SELECT @TongTien = SUM(Quantily * Price)
    FROM dbo.order_detail
    WHERE order_id = @order_id;
    
    RETURN ISNULL(@TongTien, 0);
END;

–kiểm tra
SELECT dbo.fn_TinhTongTienDonHang(39) AS TongTienDonHang;
SELECT order_id, dbo.fn_TinhTongTienDonHang(order_id) AS TongTien FROM dbo.orders;
        </textarea>
                            </div>
                            <div class="row g-2 mb-3">

                                <div class="col-3">
                                    <label class="form-label fw-semibold">Order</label>
                                    <select name="order_id" class="form-control select2" required>
                                        @foreach ($orders as $order)
                                        <option value="{{ $order->order_id }}"
                                            {{ session('orderIdProductPrice') == $order->order_id ? 'selected' : '' }}>
                                            #{{ $order->order_id }} — {{ $order->status }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">
                                fn_totalProductPrice
                            </button>
                        </form>
                        <hr>
                        <div id="result-totalProductPrice">

                            @if(session('totalProductPriceResult'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Tổng tiền đơn hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ session('totalProductPriceResult')->order_id }}</td>
                                        <td>{{ number_format(session('totalProductPriceResult')->TongTienDonHang) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @endif

                        </div>

                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='totalProductByCategory'?'show active':'' }}"
                        id="tab-totalProductByCategory">

                        <form action="{{ route('user.totalProductByCategory') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE FUNCTION dbo.fn_TinhTongSoLuongSanPham(@cate_id INT)
RETURNS INT
AS
BEGIN
    DECLARE @TongSoLuong INT;
    
    SELECT @TongSoLuong = SUM(CAST(Quantily AS INT))
    FROM dbo.product
    WHERE cate_id = @cate_id;
    
    RETURN ISNULL(@TongSoLuong, 0);
END;
-- kiểm tra
SELECT dbo.fn_TinhTongSoLuongSanPham(4) AS TongSoLuongDongHoNam;
SELECT c.Category_ID, c.Category_name, dbo.fn_TinhTongSoLuongSanPham(c.Category_ID) AS TongSoLuong
FROM dbo.category c;

        </textarea>
                            </div>
                            <div class="row g-2 mb-3">

                                <div class="col-3">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="category_id" class="form-control select2" required>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->Category_ID }}"
                                            {{ session('categoryIdProductQuantity') == $category->Category_ID ? 'selected' : '' }}>
                                            #{{ $category->Category_ID }} — {{ $category->Category_name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary">
                                fn_totalProductByCategory
                            </button>
                        </form>
                        <hr>
                        <div id="result-totalProductQuantity">

                            @if(session('totalProductQuantityResult'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>Category ID</th>
                                        <th>Tổng số lượng sản phẩm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ session('totalProductQuantityResult')->Category_ID }}</td>
                                        <td>{{ session('totalProductQuantityResult')->TongSoLuong }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            @else
                            <div class="alert alert-info">
                                Không có sản phẩm trong danh mục này.
                            </div>
                            @endif

                        </div>
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='monthlyRevenueReport_Cursor'?'show active':'' }}"
                        id="tab-monthlyRevenueReport_Cursor">

                        <form action="{{ route('monthly.revenue.report.cursor') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
CREATE PROCEDURE sp_MonthlyRevenueReport_Cursor
AS
BEGIN
    SET NOCOUNT ON;

    IF NOT EXISTS (SELECT 1 FROM orders WHERE status = 'PAID')
    BEGIN
        PRINT N'không có dữ liệu đơn hàng PAID';
        RETURN;
    END

    DECLARE @Nam INT,
			@Thang INT,
			@SoLuongDon INT,
			@TongDoanhThu FLOAT,
			@TrungBinhMoiDon FLOAT;


    DECLARE @KetQua TABLE (
        Nam INT,
        Thang INT,
        SoLuongDon INT,
        TongDoanhThu FLOAT,
        TrungBinhMoiDon FLOAT );


    DECLARE cur_Month CURSOR LOCAL FAST_FORWARD FOR
        SELECT DISTINCT 
				YEAR(created_at) AS Nam,
				MONTH(created_at) AS Thang
        FROM orders
        WHERE status = 'PAID';

    OPEN cur_Month;

    FETCH NEXT FROM cur_Month INTO @Nam, @Thang;

    WHILE @@FETCH_STATUS = 0
    BEGIN
        SELECT 
				@SoLuongDon = COUNT(order_id),
				@TongDoanhThu = SUM(amount),
				@TrungBinhMoiDon = AVG(amount)
        FROM orders
        WHERE status = 'PAID'
          AND YEAR(created_at) = @Nam
          AND MONTH(created_at) = @Thang;

        INSERT INTO @KetQua VALUES (@Nam, @Thang, @SoLuongDon, @TongDoanhThu, @TrungBinhMoiDon);

        FETCH NEXT FROM cur_Month INTO @Nam, @Thang;
    END

    CLOSE cur_Month;
    DEALLOCATE cur_Month;

    SELECT *
    FROM @KetQua
    ORDER BY Nam DESC, Thang DESC;
END;
GO

EXEC sp_MonthlyRevenueReport_Cursor;


        </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                fn_totalProductByCategory
                            </button>
                        </form>
                        <hr>
                        <div id="result-monthlyRevenueCursor">

                            @if(session('monthlyRevenueCursorResults'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>Năm</th>
                                        <th>Tháng</th>
                                        <th>Số lượng đơn</th>
                                        <th>Tổng doanh thu</th>
                                        <th>Trung bình / đơn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('monthlyRevenueCursorResults') as $item)
                                    <tr>
                                        <td>{{ $item->Nam }}</td>
                                        <td>{{ $item->Thang }}</td>
                                        <td>{{ $item->SoLuongDon }}</td>
                                        <td>{{ number_format($item->TongDoanhThu) }}</td>
                                        <td>{{ number_format($item->TrungBinhMoiDon) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif

                        </div>

                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='Best_selling_products'?'show active':'' }}"
                        id="tab-Best_selling_products">

                        <form action="{{ route('best.selling.products') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:</label>
                                <textarea class="form-control font-monospace auto-resize" readonly>
create PROC Best_selling_products
AS
BEGIN
    SET NOCOUNT ON;

		DECLARE 
			@ProductID INT,
			@TenSP NVARCHAR(100),
			@TongDaBan INT,
			@XepLoai NVARCHAR(50);

		DECLARE @KetQua TABLE (
			Product_ID INT,
			TenSanPham NVARCHAR(100),
			TongSoLuongDaBan INT,
			XepLoai NVARCHAR(50)
		);

    DECLARE CUR_Product CURSOR LOCAL FAST_FORWARD FOR
    SELECT Product_ID, Name FROM product;

    OPEN CUR_Product;
    FETCH NEXT FROM cur_Product INTO @ProductID, @TenSP;

    WHILE @@FETCH_STATUS = 0
    BEGIN
        SELECT @TongDaBan = ISNULL(SUM(Quantily), 0)
        FROM order_detail
        WHERE Product_ID = @ProductID;

        IF @TongDaBan >= 10 
            SET @XepLoai = N'BÁN CHẠY';
        ELSE IF @TongDaBan >= 5 
            SET @XepLoai = N'BÁN TRUNG BÌNH';
        ELSE 
            SET @XepLoai = N'BÁN CHẬM';

        INSERT INTO @KetQua VALUES (@ProductID, @TenSP, @TongDaBan, @XepLoai);

        FETCH NEXT FROM CUR_Product INTO @ProductID, @TenSP;
    END

    CLOSE CUR_Product;
    DEALLOCATE CUR_Product;

    SELECT * FROM @KetQua
    ORDER BY TongSoLuongDaBan DESC;
END;
GO

EXEC Best_selling_products;
        </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                fn_Best_selling_products
                            </button>
                        </form>
                        <hr>
                        <div id="result-bestSellingProducts">

                            @if(session('bestSellingProductsResults'))
                            <table class="table table-bordered table-striped">
                                <thead class="table-success">
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Tổng số lượng đã bán</th>
                                        <th>Xếp loại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(session('bestSellingProductsResults') as $item)
                                    <tr>
                                        <td>{{ $item->Product_ID }}</td>
                                        <td>{{ $item->TenSanPham }}</td>
                                        <td>{{ $item->TongSoLuongDaBan }}</td>
                                        <td>
                                            <span class="badge
                    @if($item->XepLoai === 'BÁN CHẠY') bg-success
                    @elseif($item->XepLoai === 'BÁN TRUNG BÌNH') bg-warning
                    @else bg-secondary
                    @endif
                ">
                                                {{ $item->XepLoai }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Không có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            @endif

                        </div>

                    </div>
                    <!-- <div class="tab-pane fade {{ session('activeTab')=='reportProduct'?'show active':'' }}"
                        id="tab-reportProduct">

                        ffffw3
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='reportProduct'?'show active':'' }}"
                        id="tab-reportProduct">

                        ffffw3
                    </div>
                    <div class="tab-pane fade {{ session('activeTab')=='reportProduct'?'show active':'' }}"
                        id="tab-reportProduct">

                        ffffw3
                    </div> -->

                </div>


























                <div class="container py-4">
                    <div class="mb-5"></div>
                    <!-- product -->
                    <div class="row product">
                        <h2 class="mb-4 text-primary">1. Sản phẩm</h2>
                        <form action="{{ route('product.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">1.1. Thêm sản phẩm</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.product ( NAME,[ Description ],
  cate_id,
  Img,
  Price,
  Quantily 
)
VALUES
  ( N 'Sản phẩm A', N 'Mô tả sản phẩm A', 1, N 'img_a.jpg', 120000, N '10' );</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storeProduct</button>
                        </form>
                        <hr>
                        <form action="{{ route('product.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">SQL SERVER:

                                </label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>CREATE PROCEDURE sp_UpdateProductPrice
 @Product_ID INT,
 @NewPrice FLOAT,
 @UserID INT,
 @Reason NVARCHAR(255)
AS
BEGIN
    SET NOCOUNT ON;
 
    DECLARE @OldPrice FLOAT;
    DECLARE @PercentChange FLOAT;
 
    IF NOT EXISTS (SELECT 1 FROM users WHERE id = @UserID)
    BEGIN
        PRINT N' User không tồn tại';
        RETURN;
    END
 
    IF NOT EXISTS (SELECT 1 FROM product WHERE Product_ID = @Product_ID)
    BEGIN
        PRINT N'Sản phẩm không tồn tại';
        RETURN;
    END
 
    SELECT @OldPrice = Price
    FROM product
    WHERE Product_ID = @Product_ID;
 
    IF @NewPrice <= 0
    BEGIN
        PRINT N' Giá mới phải lớn hơn 0';
        RETURN;
    END
 
    IF @NewPrice = @OldPrice
    BEGIN
        PRINT N' Giá mới giống giá cũ, không cần cập nhật';
        RETURN;
    END
    SET @PercentChange = ((@NewPrice - @OldPrice) / @OldPrice) * 100;
 
    UPDATE product
    SET Price = @NewPrice
    WHERE Product_ID = @Product_ID;
    PRINT N'Cập nhật giá thành công';
 
    SELECT 
        Product_ID,
        Name,
        @OldPrice AS GiaCu,
        @NewPrice AS GiaMoi,
        @PercentChange AS PhanTramThayDoi,
        GETDATE() AS ThoiGianCapNhat,
        @Reason AS LyDo
    FROM product
    WHERE Product_ID = @Product_ID;
END;
 
-- kiểm tra update giá mới
EXEC sp_UpdateProductPrice
    @Product_ID = 20,
    @NewPrice = 15,
    @UserID = 1,
    @Reason = N'Giảm giá cho sự kiện đầu năm 2026';
-- kiểm tra lỗi nếu giá âm
EXEC sp_UpdateProductPrice
    @Product_ID = 20,
    @NewPrice = -20,
    @UserID = 1,
    @Reason = N'Giảm giá cho sự kiện đầu năm 2026';
--kiểm tra lỗi nếu giá mới giống giá cũ
EXEC sp_UpdateProductPrice
    @Product_ID = 20,
    @NewPrice = 15,
    @UserID = 1,
    @Reason = N'Giảm giá cho sự kiện đầu năm 2026';

                        </textarea>
                            </div>
                            <label class="form-label fw-semibold">Tham số EXEC (chỉ được sửa số)</label>

                            <div class="row g-2">
                                <div class="col">
                                    <label class="form-label fw-semibold">NewPrice</label>
                                    <input type="number" name="new_price" class="form-control" placeholder="@NewPrice" required value="{{ session('updateNewPrice', 100000) }}">
                                </div>
                                <div class="col">
                                    <label class="form-label fw-semibold">User</label>
                                    <select name="user_id" class="form-control select2" required>
                                        @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ session('updateUserId', 16) == $user->id ? 'selected' : '' }}>
                                            {{ $user->id }} - {{ $user->fullname }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="col">
                                    <!-- <input type="number" name="Product_ID" class="form-control" placeholder="@Product_ID" required value="{{ session('productIdCheckout', 23) }}"> -->
                                    <label class="form-label fw-semibold">Product</label>
                                    <select name="product_id" class="form-control select2" required>
                                        @foreach ($products as $product)
                                        <option value="{{ $product->Product_ID }}"
                                            {{ session('updateProductId', 23) == $product->Product_ID ? 'selected' : '' }}>
                                            {{ $product->Product_ID }} - {{ $product->Name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mt-2">
                                <label class="form-label fw-semibold">Reason</label>
                                <input type="text" name="reason" class="form-control"
                                    placeholder="@Reason" required value="{{ session('updateReason', 'Giảm giá cho sự kiện đầu năm 2026') }}">
                            </div>
                            <button type="submit" class="btn btn-primary">updateProduct</button>
                        </form>
                        <hr>
                        <form action="{{ route('product.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">1.3. Xóa sản phẩm</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>DELETE FROM dbo.product WHERE Product_ID = 17;
                        </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">deleteProduct</button>
                        </form>
                        <hr>
                        <div id="result-storeProduct">

                            <table border="1" cellpadding="8" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Mô tả</th>
                                        <th>Danh mục</th>
                                        <th>Ảnh</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $item)
                                    <tr>
                                        <td>{{ $item->Product_ID }}</td>
                                        <td>{{ $item->Name }}</td>
                                        <td>{{ $item->Description }}</td>
                                        <td>{{ $item->cate_id }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->Img) }}"
                                                alt="{{ $item->Img }}"
                                                width="100">
                                        </td>

                                        <td>{{ $item->Price }}</td>
                                        <td>{{ $item->Quantily }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="mb-5"></div>
                    <!-- Category -->
                    <div class="row category">
                        <h2 class="mb-4 text-primary">2. Danh mục</h2>
                        <form action="{{ route('category.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">2.1. Thêm danh mục</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.category ( Category_name, Category_description )
VALUES
  ( N 'Danh mục A', N 'Mô tả danh mục A' );
                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storeCategory</button>
                        </form>
                        <hr>
                        <form action="{{ route('category.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">2.2. Chỉnh sửa danh mục</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.category 
SET Category_name = N 'Danh mục A',
Category_description = N 'Mô tả danh mục A' 
WHERE
  Category_ID = 7;
                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">updateCategory</button>
                        </form>
                        <hr>
                        <form action="{{ route('category.delete') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">2.3. Xóa danh mục</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required> DELETE FROM dbo.category WHERE Category_ID = 7;
                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">deleteCategory</button>
                        </form>
                        <hr>
                        <div id="result-storeCategory">

                            <table border="1" cellpadding="8" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Mô tả</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $item)
                                    <tr>
                                        <td>{{ $item->Category_ID }}</td>
                                        <td>{{ $item->Category_name }}</td>
                                        <td>{{ $item->Category_description }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="mb-5"></div>
                    <!-- contact -->
                    <div class="row contact">
                        <h2 class="mb-4 text-primary">3. Liên hệ</h2>
                        <form action="{{ route('contact.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">3.1. Thêm liên hệ</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.contact ( email, note, created_at, NAME )
VALUES
  ( N 'test@gmail.com', N 'Khách hàng VIP', '2026-01-26 10:30:00', N 'Nguyễn Văn B' );
                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storeContact</button>
                        </form>
                        <hr>
                        <form action="{{ route('contact.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">3.2. Chỉnh sửa liên hệ</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.contact
                        SET
                            email = N'test@gmail.com',
                            note = N'Khách hàng VIP',
                            created_at = '2026-01-26 10:30:00',
                            name = N'Nguyễn Văn B'
                        WHERE contact_id = 1;

                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">updateContact</button>
                        </form>
                        <hr>
                        <form action="{{ route('contact.delete') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">3.3. Xóa liên hệ</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>DELETE FROM dbo.contact WHERE contact_id = 1;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">deleteContact</button>
                        </form>
                        <hr>
                        <div id="result-storeContact">

                            <table border="1" cellpadding="8" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Ghi chú</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $item)
                                    <tr>
                                        <td>{{ $item->contact_id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="mb-5"></div>
                    <!-- User -->
                    <div class="row user">
                        <h2 class="mb-4 text-primary">4. User</h2>
                        <form action="{{ route('user.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">4.1. Thêm User</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.users (username,password,fullname) VALUES (N'admin',N'123456',N'Nguyễn Văn Admin');
                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storeUser</button>
                        </form>
                        <hr>
                        <form action="{{ route('user.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">4.2. Chỉnh sửa User</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.users SET password = N'123456', fullname = N'Nguyễn Văn Admin' WHERE id = 24;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">updateUser</button>
                        </form>
                        <hr>
                        <form action="{{ route('user.delete') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">4.3. Xóa User</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>DELETE FROM dbo.users WHERE id = 23;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">deleteUser</button>
                        </form>
                        <hr>
                        <div id="result-storeUser">

                            <table border="1" cellpadding="8" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Fullname</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->username }}</td>
                                        <td>{{ $item->fullname }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="mb-5"></div>
                    <!-- profile -->
                    <div class="row profile">
                        <h2 class="mb-4 text-primary">5. Profile</h2>
                        <form action="{{ route('profile.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">5.1. Thêm Profile</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.profile (
    user_id,
    address,
    email,
    birthday,
    image,
    name,
    phone
)
VALUES (
    1,
    N'123 Nguyễn Trãi, Quận 1, TP.HCM',
    N'test@gmail.com',
    N'1995-10-20',
    N'avatar.jpg',
    N'Nguyễn Văn A',
    N'0909123456'
);


                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storeProfile</button>
                        </form>
                        <hr>
                        <form action="{{ route('profile.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">5.2. Chỉnh sửa Profile</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.profile
SET
    user_id = 1,
    address = N'123 Nguyễn Trãi, Quận 1, TP.HCM',
    email = N'test@gmail.com',
    birthday = N'1995-10-20',
    image = N'avatar.jpg',
    name = N'Nguyễn Văn A',
    phone = N'0909123456'
WHERE id_profile = 1;

                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">updateProfile</button>
                        </form>
                        <hr>
                        <form action="{{ route('profile.delete') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">5.3. Xóa Profile</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>DELETE FROM dbo.profile WHERE id_profile = 8;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">deleteProfile</button>
                        </form>
                        <hr>
                        <div id="result-storeUser">

                            <table border="1" cellpadding="8" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User Id</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>SĐT</th>
                                        <th>Ngày Sinh</th>
                                        <th>Địa chỉ</th>
                                        <th>Hình ảnh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($profiles as $item)
                                    <tr>
                                        <td>{{ $item->id_profile }}</td>
                                        <td>{{ $item->user_id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->phone }}</td>
                                        <td>{{ $item->birthday }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>
                                            <img src="{{ $item->image }}" alt="{{ $item->image }}" width="100">
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="mb-5"></div>
                    <!-- PTTT -->
                    <div class="row pttt">
                        <h2 class="mb-4 text-primary">6. Phương thức thanh toán</h2>
                        <form action="{{ route('paymentgetway.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">6.1. Thêm PTTT</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.payment_methods ( name_key, created_at, updated_at )
VALUES( N 'cash', '2026-01-04 00:06:50', '2026-01-04 00:06:50' );
                    </textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storePaymentGetway</button>
                        </form>
                        <hr>
                        <form action="{{ route('paymentgetway.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">6.2. Chỉnh sửa PTTT</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.payment_methods SET name_key = N'cash' WHERE id = 4;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">updatePaymentGetway</button>
                        </form>
                        <hr>
                        <form action="{{ route('paymentgetway.delete') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">6.3. Xóa PTTT</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.payment_methods SET deleted_at = '2026-01-04 00:06:50' WHERE id = 4;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">deletePaymentGetway</button>
                        </form>
                        <hr>
                        <div id="result-storeUser">

                            <table border="1" cellpadding="4" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name Key</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paymentGetways as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name_key }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="mb-5"></div>
                    <!-- Đơn hàng -->
                    <div class="row order">
                        <h2 class="mb-4 text-primary">7. Đơn hàng</h2>
                        <form action="{{ route('order.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">7.1. Thêm Đơn hàng</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>INSERT INTO dbo.order (
    user_id,
    created_at,
    payment_method_id,
    shipping,
    status,
    note,
    order_user,
    updated_at,
    transport,
    address,
    amount
)
VALUES (
    1,
    GETDATE(),
    1,
    N'Giao hàng nhanh',
    N'PENDING',
    N'Đơn hàng mới',
    1,
    GETDATE(),
    N'Xe máy',
    N'123 Nguyễn Trãi, Quận 1',
    1500000
);

DECLARE @order_id INT;
SET @order_id = SCOPE_IDENTITY();

INSERT INTO dbo.order_detail (
    order_id,
    Product_ID,
    Quantily,
    Price
)
VALUES (
    @order_id,
    10,
    2,
    750000
);

</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">storeOrder</button>
                        </form>
                        <hr>
                        <form action="{{ route('order.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">7.2. Chỉnh sửa Đơn hàng</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>UPDATE dbo.order
SET
    user_id = 1,
    created_at = GETDATE(),
    payment_method_id = 1,
    shipping = N'Giao hàng nhanh',
    status = N'PENDING',
    note = N'Đơn hàng mới',
    order_user = 1,
    updated_at = GETDATE(),
    transport = N'Xe máy',
    address = N'123 Nguyễn Trãi, Quận 1',
    amount = 1500000
WHERE order_id = 53;
UPDATE dbo.order_detail
SET
    Product_ID = 10,
    Quantily = 2,
    Price = 750000
WHERE order_id = 53;

</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">updateOrder</button>
                        </form>
                        <hr>
                        <form action="{{ route('order.delete') }}" method="POST" class="card shadow-sm p-4 mb-4">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">7.3. Xóa Đơn hàng</label>
                                <textarea
                                    name="sql"
                                    class="form-control font-monospace auto-resize"
                                    placeholder="Dán câu SQL Server vào đây..."
                                    readonly
                                    required>DELETE FROM dbo.order WHERE order_id = 53;
                        DELETE FROM dbo.order_detail WHERE order_id = 53;
                    </textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">deleteOrder</button>
                        </form>
                        <hr>
                        <div id="result-storeUser">

                            <table border="1" cellpadding="9" cellspacing="0" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>PTTT</th>
                                        <th>Số tiền</th>
                                        <th>Trang thái</th>
                                        <th>shipping</th>
                                        <th>transport</th>
                                        <th>order_user</th>
                                        <th>Địa chỉ</th>
                                        <th>Ghi chú</th>
                                        <th>Ngày tạo</th>
                                        <th>Ngày cập nhật</th>
                                        <th>Chi tiết đơn hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $item)
                                    <tr>
                                        <td>{{ $item->order_id }}</td>
                                        <td>{{ $item->user_id }} - {{ $item->user_fullname }}</td>
                                        <td>{{ $item->payment_method_id }} - {{ $item->payment_method_name }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->shipping }}</td>
                                        <td>{{ $item->transport }}</td>
                                        <td>{{ $item->order_user }}</td>
                                        <td>{{ $item->address }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>{{ $item->updated_at }}</td>
                                        <td>
                                            <p>- Tên SP: {{ $item->product_name }} </p>
                                            <p>- Số lượng: {{ $item->order_quantity }} / {{ $item->product_quantity }}</p>
                                            <p>- Giá: {{ $item->product_price }}</p>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" align="center">Chưa có dữ liệu</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            placeholder: 'Chọn một giá trị',
                            allowClear: true,
                            width: '100%'
                        });
                    });
                </script>
                <script>
                    document.addEventListener('DOMContentLoaded', () => {

                        const autoResize = (el) => {
                            el.style.height = 'auto';
                            el.style.height = el.scrollHeight + 'px';
                        };

                        // Resize tất cả textarea đang hiển thị
                        document.querySelectorAll('textarea.auto-resize').forEach(el => {
                            autoResize(el);
                            el.addEventListener('input', () => autoResize(el));
                        });

                        // 🔥 QUAN TRỌNG: resize lại khi switch tab
                        document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
                            tab.addEventListener('shown.bs.tab', () => {
                                document
                                    .querySelectorAll('.tab-pane.active textarea.auto-resize')
                                    .forEach(el => autoResize(el));
                            });
                        });

                    });
                </script>


                <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

                <script>
                    toastr.options = {
                        closeButton: true,
                        progressBar: true
                    };

                    @if(Session::has('success'))
                    toastr.success("{{ session('success') }}");
                    @endif

                    @if(Session::has('error'))
                    toastr.error("{{ session('error') }}");
                    @endif

                    @if(Session::has('info'))
                    toastr.info("{{ session('info') }}");
                    @endif

                    @if(Session::has('warning'))
                    toastr.warning("{{ session('warning') }}");
                    @endif
                </script>

</body>

</html>