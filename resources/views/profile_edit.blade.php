<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('includes/head')
    <div class="container " style="margin-top:100px ">
        <h3>Chỉnh sửa thông tin cá nhân</h3>
        <br>
        <hr>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{url('cap-nhat-profile')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $item->email }}" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $item->phone }}" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $item->address }}" required>
            </div>

            <div class="mb-3">
                <label for="birthday" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" id="birthday" name="birthday" value="{{ $item->birthday }}" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" id="image" name="image">
                @if($item->image)
                    <img src="{{ asset($item->image) }}" alt="Profile Image" style="max-width: 100px; margin-top: 10px;">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</body>
@include('includes/footer')
</html>
