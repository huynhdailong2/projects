<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông tin cá nhân</title>
</head>
<body>
    <h1>Chỉnh sửa thông tin cá nhân</h1>

    <!-- Hiển thị lỗi nếu có -->
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Hiển thị thông báo thành công -->
    @if (session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <!-- Form chỉnh sửa thông tin người dùng -->
    <form action="{{ url('profiles/' . $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Dùng PUT vì chúng ta sẽ cập nhật thông tin -->

        <!-- Tên người dùng -->
        <div>
            <label for="name">Họ tên:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}">
        </div>

        <!-- Địa chỉ -->
        <div>
            <label for="address">Địa chỉ:</label>
            <input type="text" id="address" name="address" value="{{ old('address', $item->address) }}">
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email', $item->email) }}">
        </div>

        <!-- Số điện thoại -->
        <div>
            <label for="phone">Số điện thoại:</label>
            <input type="text" id="phone" name="phone" value="{{ old('phone', $item->phone) }}">
        </div>

        <!-- Ngày sinh -->
        <div>
            <label for="birthday">Ngày sinh:</label>
            <input type="date" id="birthday" name="birthday" value="{{ old('birthday', $item->birthday) }}">
        </div>

        <!-- Ảnh đại diện -->
        <div>
            <label for="image">Ảnh đại diện:</label>
            @if($item->image)
                <img src="{{ asset($item->image) }}" alt="Ảnh đại diện" style="max-width: 200px;">
            @else
                <p>Chưa có ảnh</p>
            @endif
            <input type="file" id="image" name="image">
        </div>

        <!-- Nút cập nhật -->
        <div>
            <button type="submit">Cập nhật</button>
        </div>
    </form>
</body>
</html>
