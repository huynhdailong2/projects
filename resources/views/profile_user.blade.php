<!DOCTYPE html>
<html>

<head>
    <title>trang cá nhân</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

@include('includes/head')

<body>

    <section style="background-color: #eee;">
        <div class="container py-5" style="margin-top:100px ">
            @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div>
                {{ session('success') }}
            </div>
            @endif
            <form action="#" method="get" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">
                                @if(isset($item) && $item->image)
                                <img src="{{ asset($item->image) }}" alt="Profile Image"
                                    style="max-width: 200px; height:200px">
                                @else
                                <p>No image available</p>
                                @endif
                                <h5 class="my-3">{{$item->name}}</h5>
                                <p class="text-muted mb-1">{{$item->email}}</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <!-- Nút Chỉnh sửa với link tới trang chỉnh sửa profile -->
                                    <a href="/profiles/{{$item->user_id}}/edit" class="btn btn-primary">Chỉnh sửa</a>

                                
                                    <!-- Nút Message nếu cần, có thể tùy chỉnh -->
                                    <button type="button" class="btn btn-outline-primary ms-1">Message</button>
                                </div>
                                
                                
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Full Name</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="name" name="name" value="{{$item->name}}">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" value="{{ $item->email }}">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="phone" name="phone" value="{{ $item->phone }}">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Address</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="address" name="address" value="{{$item->address}}" style="width: 200px">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row" style="padding:20px">
                                <div class="col-sm-3">
                                    Birthday
                                </div>

                                <div class="col-sm-9">
                                    <input type="text" id="birthday" name="birthday"
                                        value="{{ date('d-m-Y', strtotime($item->birthday)) }}">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">Thời gian xem các sản phẩm</span>
                                   Lựa xem mua sắm
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Giày dép<p></p></p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Đồng hồ</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%"
                                            aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Trang sức</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%"
                                            aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Phụ kiện</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%"
                                            aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Điện thoại</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%"
                                            aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-4 mb-md-0">
                                <div class="card-body">
                                    <p class="mb-4"><span class="text-primary font-italic me-1">Sở thích</span>
                                     
                                    </p>
                                    <p class="mb-1" style="font-size: .77rem;">Trang sức bạc </p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 80%"
                                            aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Búp bê</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 72%"
                                            aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Dép</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 89%"
                                            aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Son môi</p>
                                    <div class="progress rounded" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 55%"
                                            aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <p class="mt-4 mb-1" style="font-size: .77rem;">Body mist</p>
                                    <div class="progress rounded mb-2" style="height: 5px;">
                                        <div class="progress-bar" role="progressbar" style="width: 66%"
                                            aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        </div>
    </section>

</body>
@include('includes/footer')

</html>