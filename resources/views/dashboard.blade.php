<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đồng hồ</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img"> LUXURY WATCH
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRN8ZhApR3_p1_YAttCcQ74Mrl49hPfWA8ACQ&s"
                            alt="Luxury Watch Logo"
                            style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; ">
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">

                            <span class="hide-menu">Home</span>
                        </li>
                        <!-- <li class="sidebar-item">
                            <a class="sidebar-link" href="./index.html" aria-expanded="false">
                                <span>
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li> -->
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Quản lí </span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.products.list') }}" aria-expanded="false">
                                <span>
                                    <i class="bi bi-cart"></i>
                                </span>
                                <span class="hide-menu">Danh sách sản phẩm</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.categories.list') }}" aria-expanded="false">
                                <span>
                                    <i class="bi bi-list-ul"></i>
                                </span>
                                <span class="hide-menu">Danh sách danh mục</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.orders.list') }}" aria-expanded="false">
                                <span>
                                    <i class="bi bi-list-ul"></i>
                                </span>
                                <span class="hide-menu">Danh sách đặt hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.contacts.list') }}" aria-expanded="false">
                                <span>
                                    <i class="bi bi-list-ul"></i>
                                </span>
                                <span class="hide-menu">Danh sách liên hệ</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.users.list') }}" aria-expanded="false">
                                <span>
                                    <i class="bi bi-person"></i>
                                </span>
                                <span class="hide-menu">Danh sách người dùng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ route('admin.payment.list') }}" aria-expanded="false">
                                <span>
                                    <i class="bi bi-person"></i>
                                </span>
                                <span class="hide-menu">Danh sách thanh toán</span>
                            </a>
                        </li>

                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">AUTH</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="/" aria-expanded="false">
                                <span>
                                    <i class="ti ti-login"></i>
                                </span>
                                <span class="hide-menu">Chuyển đến trang home</span>
                            </a>
                        </li>
            


                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!--  Sidebar End -->
        <!--  Main wrapper -->

    </div>
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>
    <script src="../assets/js/dashboard.js"></script>
</body>

</html>
