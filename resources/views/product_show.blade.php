<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> --}}
    <title>Tất cả sản phẩm</title>
    @include('includes/head')
    <style>
        .product-button {
            display: flex;
            align-items: center;
            justify-content: center;
            /* background: linear-gradient(45deg, #d32f2f, #ff5722, #ffffff); */
            background: linear-gradient(45deg, #0f0053, #1bfff0, #bfecff);
            color: white;
            border: none;
            padding: 6px 60px;
            font-size: 0.9rem;
            cursor: pointer;
            border-radius: 50px;
            transition: background 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .product-button:hover {
            /* background: linear-gradient(45deg, #0f0053, #51fb95, #ffffff); */
            background: linear-gradient(45deg, #d32f2f, #ff5722, #ffffff);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }


        /* Hiệu ứng hover cho badge */

        .back-to-home-button {
            position: fixed;
            top: 20px;
            /* Cách cạnh trên */
            left: 20px;
            /* Cách cạnh trái */
            font-size: 16px;
            display: flex;
            align-items: center;
            color: #007bff;
            background-color: transparent;
            border: none;
            padding: 10px;
            text-decoration: none;
            transition: color 0.3s ease;
            z-index: 999;
            /* Đảm bảo nút ở trên cùng */
        }

        .back-to-home-button:hover {
            color: #0056b3;
            /* Đổi màu khi hover */
        }

        .back-to-home-button i {
            margin-right: 8px;
            /* Khoảng cách giữa biểu tượng và chữ */
        }

        .toggle-btn {
            background-color: white;
            /* Nền trắng */
            color: #007bff;
            /* Màu chữ xanh dương */
            border: 1px solid #007bff;
            /* Viền xanh dương */
            padding: 3px 10px;
            /* Padding nhỏ hơn */
            font-size: 12px;
            /* Chữ nhỏ hơn */
            border-radius: 10px;
            /* Viền bo tròn nhẹ */
            cursor: pointer;
            transition: all 0.3s ease;
            /* Hiệu ứng mượt hơn cho toàn bộ các trạng thái */
            text-decoration: none;
            margin: 10px;
        }

        /* Hiệu ứng hover */
        .toggle-btn:hover {
            background-color: #000000;
            /* Nền xanh dương */
            color: white;
            /* Chữ trắng */
            transform: translateY(-2px);
            /* Hiệu ứng nổi lên nhẹ */
        }

        /* Hiệu ứng focus (khi được chọn) */
        .toggle-btn:focus {
            outline: none;
            /* Xóa viền focus mặc định */
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            /* Thêm bóng nhẹ khi focus */
        }

        /* Hiệu ứng active (khi nhấn vào) */
        .toggle-btn:active {
            background-color: #0056b3;
            /* Màu nền khi nhấn */
            color: white;
            /* Chữ trắng khi nhấn */
            transform: translateY(0);
            /* Quay lại vị trí ban đầu */
        }

        /* CSS cho mô tả */
        .product-description {
            font-size: 12px;

            color: #555;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* Hiển thị 3 dòng đầu tiên */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

</head>

<body>

    <div class="toast-container">
        @if (session('success'))
        <div class="toast align-items-center text-white bg-info border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="successToast">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        @endif
        @if (session('error'))
        <div class="toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="errorToast">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
        @endif
    </div>

    <div class="row isotope-grid" style="margin: 120px 0; display: flex; flex-wrap: wrap; gap: 30px;">
        @foreach ($products as $product)
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women"
            style="box-sizing: border-box; padding: 25px; display: flex; justify-content: center;">
            <!-- Block2 -->
            <div class="block2" style="background: linear-gradient(to top left, #f5f5f5, #dcdcdc, #ffffff); 
                                        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1); 
                                        border-radius: 15px; padding: 20px; position: relative; 
                                        transition: transform 0.3s ease-in-out, box-shadow 0.2s ease-in-out; 
                                        overflow: hidden; width: 100%; display: flex; flex-direction: column;">
                <div class="block2-pic hov-img0" style="position: relative; overflow: hidden; border-radius: 15px;">
                    <a href="/product-detail/{{$product->Product_ID}}"
                        style="display: block; position: relative; text-align: center;">
                        <img src="{{ asset($product->Img) }}" alt="Hình ảnh sản phẩm"
                            style="width: 100%; height:90%; object-fit: cover; border-radius: 15px;">
                        <div class="quickview" style="position: absolute; bottom: 0; left: 0; width: 100%; background-color: rgba(0, 0, 0, 0.5); 
            color: white; font-weight: bold; font-size: 18px; padding: 10px 0; 
            transform: translateY(100%); transition: transform 0.3s;">
                            Quick View
                        </div>
                    </a>
                </div>

                <div class="block2-txt flex-w flex-t p-t-14"
                    style="flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between;">
                    <div class="block2-txt-child1 flex-col-l">
                        <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"
                            style="font-size: 16px; font-weight: bold; text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            {{ $product->Name }}
                        </a>

                        <span class="stext-105 cl3" style="font-size: 14px; color: #999;">
                            <p class="product-price" style="font-size: 16px; color: #333; font-weight: 600;">
                                {{ number_format($product->Price, 0, ',', '.') }} VNĐ
                            </p>
                        </span>
                    </div>

                    <div class="block2-txt-child2 flex-r p-t-3" style="display: flex; align-items: center;">
                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2"
                            style="position: relative; display: inline-block;">
                            <img class="icon-heart1 dis-block trans-04"
                                src="{{ asset('images/icons/icon-heart-01.png') }}" alt="ICON"
                                style="width: 20px; height: 20px;">
                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                src="{{ asset('images/icons/icon-heart-02.png') }}" alt="ICON"
                                style="width: 20px; height: 20px;">
                        </a>
                    </div>
                </div>

                <form action="{{ route('cart.add', $product->Product_ID) }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit" class="product-button"
                        style="padding: 10px 20px; background-color: #ff5722; color: white; border: none; border-radius: 5px; 
                                   cursor: pointer; font-size: 14px; width: 100%; text-align: center; transition: background-color 0.3s;">
                        <i class="bi bi-cart-plus" style="margin-right: 8px;"></i> Thêm vào giỏ hàng
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @include('includes/footer')

</body>
<script>
    // Hiển thị toast khi load trang
    window.onload = function() {
        const successToast = document.getElementById('successToast');
        const errorToast = document.getElementById('errorToast');
        if (successToast) {
            const toast = new bootstrap.Toast(successToast);
            toast.show();
        }
        if (errorToast) {
            const toast = new bootstrap.Toast(errorToast);
            toast.show();
        }
        // Kiểm tra nếu mô tả dài hơn 3 dòng thì hiển thị nút "Xem thêm"
        const descriptions = document.querySelectorAll('.product-description');
        descriptions.forEach(description => {
            const productId = description.id.split('-')[1];
            const button = document.getElementById('toggle-btn-' + productId);
            // Nếu nội dung vượt quá 3 dòng, hiển thị nút "Xem thêm"
            if (description.scrollHeight > description.offsetHeight) {
                button.style.display = 'inline-block'; // Hiển thị nút "Xem thêm"
            }
        });
    };

    function toggleDescription(productId) {
        const description = document.getElementById('description-' + productId);
        const button = document.getElementById('toggle-btn-' + productId);
        // Kiểm tra trạng thái hiện tại của mô tả
        if (description.style.webkitLineClamp === '3') {
            description.style.webkitLineClamp = 'unset'; // Hiển thị hết mô tả
            description.style.overflow = 'visible'; // Đảm bảo không bị cắt
            button.innerHTML = 'Thu gọn'; // Thay đổi nội dung nút
        } else {
            description.style.webkitLineClamp = '3'; // Giới hạn lại mô tả
            description.style.overflow = 'hidden'; // Cắt bớt nội dung
            button.innerHTML = 'Xem thêm'; // Thay đổi nội dung nút
        }
    }
</script>

</html>