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
</style>

<body class="bg-light">
    <div class="container">
        <a href="https://doan.dyca.vn/" target="_blank">Về trang website</a>
    </div>
    <div class="container py-4">
        <div class="row check-sql">
            <h2 class="mb-4 text-primary">1. Sản phẩm</h2>
            <form action="{{ route('product.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">1.1. Thêm sản phẩm</label>
                    <textarea
                        name="sql"
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required>INSERT INTO dbo.product (Name,[Description],cate_id,Img,Price,Quantily) VALUES (N'Sản phẩm A', N'Mô tả sản phẩm A', 1, N'img_a.jpg', 120000, N'10');</textarea>
                </div>

                <button type="submit" class="btn btn-primary">storeProduct</button>
            </form>
            <hr>
            <form action="{{ route('product.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">1.2. Chỉnh sửa sản phẩm</label>
                    <textarea
                        name="sql"
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required>UPDATE dbo.product
                        SET
                            Name = N'Sản phẩm A',
                            [Description] = N'Mô tả sản phẩm A',
                            cate_id = 1,
                            Img = N'img_a.jpg',
                            Price = 120000,
                            Quantily = N'10'
                        WHERE Product_ID = 17;
                        </textarea>
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
        <!-- product -->
        <div class="row product">
            <h2 class="mb-4 text-primary">1. Sản phẩm</h2>
            <form action="{{ route('product.store') }}" method="POST" class="card shadow-sm p-4 mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">1.1. Thêm sản phẩm</label>
                    <textarea
                        name="sql"
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required>INSERT INTO dbo.product (Name,[Description],cate_id,Img,Price,Quantily) VALUES (N'Sản phẩm A', N'Mô tả sản phẩm A', 1, N'img_a.jpg', 120000, N'10');</textarea>
                </div>

                <button type="submit" class="btn btn-primary">storeProduct</button>
            </form>
            <hr>
            <form action="{{ route('product.update') }}" method="POST" class="card shadow-sm p-4 mb-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">1.2. Chỉnh sửa sản phẩm</label>
                    <textarea
                        name="sql"
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required>UPDATE dbo.product
                        SET
                            Name = N'Sản phẩm A',
                            [Description] = N'Mô tả sản phẩm A',
                            cate_id = 1,
                            Img = N'img_a.jpg',
                            Price = 120000,
                            Quantily = N'10'
                        WHERE Product_ID = 17;
                        </textarea>
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required>INSERT INTO dbo.category (
                            Category_name,
                            Category_description
                        )
                        VALUES (
                            N'Danh mục A',
                            N'Mô tả danh mục A'
                        );
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required> UPDATE dbo.category SET Category_name = N'Danh mục A', Category_description = N'Mô tả danh mục A' WHERE Category_ID = 7;
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
                        required>INSERT INTO dbo.contact (
                            email,
                            note,
                            created_at,
                            name
                        )
                        VALUES (
                            N'test@gmail.com',
                            N'Khách hàng VIP',
                            '2026-01-26 10:30:00',
                            N'Nguyễn Văn B'
                        );
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                        class="form-control font-monospace"
                        rows="10"
                        placeholder="Dán câu SQL Server vào đây..."
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
                                <p>- Tên SP: {{ $item->product_name }}  </p>
                                <p>- Số lượng: {{ $item->product_quantity }}</p>
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