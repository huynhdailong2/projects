<!DOCTYPE html>
<html>

<head>
    <title>Create Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @include('includes/head')
</head>

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

            <form action="{{ url('profiles') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-body text-center">

                                <input type="file" id="image" name="image">
                                <h5 class="my-3">No name</h5>
                                <p class="text-muted mb-1">Full Stack Developer</p>
                                <p class="text-muted mb-4">Bay Area, San Francisco, CA</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-primary">Follow</button>
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-outline-primary ms-1">Message</button>
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
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            placeholder="Nhập tên">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            placeholder="Nhập email">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                            placeholder="Nhập số điện thoại">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Address</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                                            placeholder="Nhập địa chỉ">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3"  >
                                        <p class="mb-0">Birthday</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="date" id="birthday" name="birthday" value="{{ old('birthday') }}">
                                    </div>
                                </div>
                                <div
                                    style="display: flex; justify-content: center; align-items: center; margin-top:10px">
                                    <button type="submit"
                                        style="padding: 6px 40px; font-size: 16px; background-color: #a7a7a7; color: white; border: none; border-radius: 5px; 
                                    cursor: pointer; box-shadow: 3px 3px 5px rgba(0, 0, 0, 0.2), -3px -3px 5px rgba(255, 255, 255, 0.5), 0 0 10px rgba(190, 190, 190, 0.7);">
                                        Save
                                    </button>
                                </div>

                            </div>
                        </div>
              
                    </div>
                </div>
            </form>

        </div>
    </section>

</body>
@include('includes/footer')

</html>