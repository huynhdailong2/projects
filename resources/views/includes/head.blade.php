<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}">

<!-- Bootstrap CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">

<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

<!-- Material Design Icons -->
<link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">

<!-- Linear Icons -->
<link rel="stylesheet" type="text/css" href="{{ asset('fonts/linearicons-v1.0.0/icon-font.min.css') }}">

<!-- Animate.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">

<!-- Hamburgers.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">

<!-- Animsition CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">

<!-- Select2 CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">

<!-- Daterangepicker CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">

<!-- Slick CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/slick/slick.css') }}">

<!-- Magnific Popup CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/MagnificPopup/magnific-popup.css') }}">

<!-- Perfect Scrollbar CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}">

<!-- Custom Util CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">

<!-- Main CSS -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">

<header>
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Chào mừng bạn đến với Luxuxy Watch
                </div>

                <div class="right-top-bar flex-w h-full">
                    @if (session()->has('username'))
                    <a href="#" class="flex-c-m trans-04 p-lr-25">
                        <li class="nav-item">
                            <span class="navbar-text">
                                <i class="bi bi-person-circle"></i> Xin chào,
                                <strong>{{ session('fullname') }}</strong>!
                            </span>
                        </li>
                    </a>

                    <li class="nav-item">
                        <!-- Nếu người dùng đã đăng nhập -->
                        <a class="nav-link logout-button" href="{{ route('user.logout') }}"
                            style="color: rgb(255, 77, 77)">
                            <i class="bi bi-door-open-fill"></i> Đăng xuất
                        </a>
                        @else
                        <!-- Nếu người dùng chưa đăng nhập -->
                        <a class="nav-link logout-button" href="{{ route('user.logins') }}"
                            style="color: rgb(255, 33, 33)">
                            <i class="bi bi-door-open-fill"></i> Đăng nhập
                        </a>
                    </li>

                    @endif

                    @if (session('username') === 'admin')
                    <li>
                        <a class="nav-link nav-link-admin" href="/admin"><i class="bi bi-shield-lock-fill"></i> Quản
                            lý</a>
                    </li>
                    @else
                    <li>
                        {{-- <a class="nav-link nav-link-admin" href="/admin"><i class="bi bi-shield-lock-fill" ></i> Quản lý</a> --}}
                    </li>
                    @endif
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="/" class="logo" style="font-size: 24px; font-weight: bold; text-decoration: none; font-family: Arial, sans-serif; text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2); 
                background: linear-gradient(to right, #00bfff, #000); 
                -webkit-background-clip: text; 
                color: transparent;">
                    LUXURY WATCH
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="active-menu">
                            <a href="/">Home</a>

                        </li>

                        <li class="label1" data-label1="hot">
                            <a href="/tat-ca-san-pham">Sản phẩm</a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="{{ route('products.filter', 'Đồng hồ nam') }}"
                                        class="{{ request()->is('products/category/Đồng hồ nam') ? 'active' : '' }}">
                                        Đồng hồ nam
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products.filter', 'Đồng hồ nữ') }}"
                                        class="{{ request()->is('products/category/Đồng hồ nữ') ? 'active' : '' }}">
                                        Đồng hồ nữ
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('products.filter', 'New') }}"
                                        class="{{ request()->is('products/category/New') ? 'active' : '' }}">
                                        New
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <li>
                            <a href="/contact-form">Liên hệ</a>
                        </li>
                        <li>
                            <a href="/profile-user">Thông tin cá nhân</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11">
                        <a href="/cart" class="cart-button" style="position: relative;">
                            <i class="zmdi zmdi-shopping-cart" style="font-size: 24px;"></i>
                            <!-- Hiển thị số lượng sản phẩm trong giỏ hàng -->
                            @php
                            $cart = session('cart', []); // Lấy dữ liệu giỏ hàng từ session
                            $totalProducts = count($cart); // Đếm số lượng sản phẩm trong giỏ hàng
                            @endphp

                            @if ($totalProducts > 0)
                            <span style="
										position: absolute;
										top: -8px;
										right: -8px;
										background-color: red;
										color: white;
										font-size: 12px;
										padding: 4px 6px;
										border-radius: 50%;
										font-weight: bold;
									">{{ $totalProducts }}</span> <!-- Hiển thị số lượng sản phẩm -->
                            @endif
                        </a>
                    </div>

                    <a href="{{ url('/hoa-don/' . session('user_id')) }}"
                        class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11"
                        data-notify="0">
                        <i class="fa fa-truck"></i>

                    </a>

                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        Help & FAQs
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        My Account
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        EN
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        USD
                    </a>
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
                <ul class="sub-menu-m">
                    <li><a href="index.html">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE">
            </button>

            <form class="wrap-search-header flex-w p-l-15">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>