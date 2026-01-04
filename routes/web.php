<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\API;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('dashboard');
});
Route::get('user/{id}/comment/{commentID}', function ($id, $commentID) {
    return "User id: $id and comment id: $commentID";
});
Route::get('/payment/paypal/success', [Controllers\CheckoutController::class, 'paypalSuccess']);
Route::get('/payment/paypal/cancel', [Controllers\CheckoutController::class, 'paypalCancel']);
//login google
Route::get('/login/google', [Controllers\GoogleLoginController::class, 'redirect'])
    ->name('login.google');

Route::get('/login/google/callback', [Controllers\GoogleLoginController::class, 'callback']);



Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('user.logout');
Route::get('update-all-passwords', [Controllers\UserController::class, 'updateAllPasswords']);
; // Hiển thị form đăng nhập
Route::post('login', [Controllers\UserController::class, 'login'])->name('user.login'); // Xử lý đăng nhập

Route::get('/login', [Controllers\UserController::class, 'logins'])->name('user.logins');

Route::get('/register-1', [Controllers\UserController::class, 'showRegisterForm'])->name('user.register.form');
Route::post('/register-2', [Controllers\UserController::class, 'save'])->name('user.register.save');

 Route::get('/profile', [Controllers\ProfileController::class, 'create']);
Route::post('/profiles', [Controllers\ProfileController::class, 'store']);
Route::get('/profile-user', [Controllers\ProfileController::class, 'show']);


// Route hiển thị trang chỉnh sửa profile (truyền id của profile vào)
Route::get('/profiles/{id}/edit', [Controllers\ProfileController::class, 'edit']);


// Route xử lý cập nhật profile sau khi chỉnh sửa
Route::post('/cap-nhat-profile', [Controllers\ProfileController::class, 'update']);


Route::get('/tat-ca-san-pham', function () {
    return view('tat-ca-san-pham');
})->middleware('auth'); // Trang cần đăng nhập


// Route::post('user-login', [Controllers\UserController::class, 'login']);
// Route::get('laydulieu', [Controllers\UserController::class, 'userLogin']);

Route::get('lay-data', [Controllers\UserController::class, 'list']);

Route::get('danh-sach', [Controllers\UserController::class, 'danhsach']);
Route::get('thong-tin-user/{id?}', [Controllers\UserController::class, 'show']);
Route::get('delete/{id?}', [Controllers\UserController::class, 'delete']);
Route::get('add-user', [Controllers\UserController::class, 'add']);
Route::post('/add-users', [Controllers\UserController::class, 'adduser']);
Route::post('cap-nhat-user', [Controllers\UserController::class, 'update']);
//


Route::get('danh-sach-danh-muc', [Controllers\CategoryController::class, 'list']);
Route::get('xoa-danh-muc/{id?}', [Controllers\CategoryController::class, 'del']);
Route::get('thong-tin-danh-muc/{id?}', [Controllers\CategoryController::class, 'show']);
Route::post('cap-nhat-danh-muc', [Controllers\CategoryController::class, 'update']);
Route::get('them-danh-muc', [Controllers\CategoryController::class, 'add']);
Route::post('them-danh-muc', [Controllers\CategoryController::class, 'save']);


//sanpham
Route::get('danh-sach-san-pham', [Controllers\ProductController::class, 'list']);
Route::get('thong-tin-san-pham/{id?}', [Controllers\ProductController::class, 'show']);
Route::get('them-san-pham', [Controllers\ProductController::class, 'add']);
Route::post('them-san-pham', [Controllers\ProductController::class, 'save']);
Route::get('xoa-san-pham/{id?}', [Controllers\ProductController::class, 'del']);
Route::post('cap-nhat-san-pham', [Controllers\ProductController::class, 'update']);
Route::get('product-detail/{id}', [Controllers\ProductController::class, 'ShowDetail']);





Route::post('/add-to-cart', [Controllers\ProductController::class, 'addToCart'])->name('addToCart');



// Route để lọc sản phẩm theo Category_name
Route::get('/products/category/{category}', [Controllers\ProductController::class, 'filterByCategory'])->name('products.filter');



Route::get('tat-ca-san-pham', [Controllers\ProductController::class, 'showAllProducts']);
//
Route::get('/', [Controllers\ProductController::class, 'showAllList']);
// web.php

//     order: 
Route::prefix('paymentgateways')->group(function () {
    Route::get('/{id}', [Controllers\API\PaymentGetwayController::class, 'status'])->name('view.paymentgateways.status');
});

Route::get('api/paymentGetwayDataMomo', [API\PaymentGetwayController::class, 'paymentGetwayDataMomo'])->name('paymentGetwayDataMomo.index');
Route::get('checkout', [Controllers\OrderController::class, 'checkout'])->name('checkout');

Route::get('/order-details', [Controllers\OrderController::class, 'orderDetails'])->name('order.details');
Route::post('/order/finalize', [Controllers\OrderController::class, 'finalize'])->name('order.finalize');
Route::get('order/details/{order_id}', [Controllers\OrderController::class, 'getOrderDetails']);
// Route cho việc cập nhật trạng thái vận chuyển cho tất cả các đơn hàng
// Route cho việc cập nhật trạng thái vận chuyển
Route::post('/order/{order_id}/update-shipping', [Controllers\OrderController::class, 'updateShipping'])->name('order.updateShipping');

// Route cho việc cập nhật trạng thái thanh toán
Route::post('/order/{order_id}/update-payment-status', [Controllers\OrderController::class, 'updatePaymentStatus'])->name('order.updatePaymentStatus');

// Route để cập nhật trạng thái thanh toán và vận chuyển
Route::post('/order/updateStatusAndShipping/{order_id}', [Controllers\OrderController::class, 'updateStatusAndShipping'])->name('order.updateStatusAndShipping');

Route::get('danh-sach-dat-hang', [Controllers\OrderController::class, 'list']);
// routes/web.php
// routes/web.php
// Đảm bảo route định nghĩa đúng tham số
Route::post('order/remove/{order_id}/{product_id}', [Controllers\OrderController::class, 'remove'])->name('order.remove');


Route::get('order', [Controllers\OrderController::class, 'list'])->name('order.list');
// Route hiển thị giỏ hàng
Route::get('cart', [Controllers\CartController::class, 'show'])->name('cart.show');

// Route thêm sản phẩm vào giỏ hàng
Route::post('cart/add/{Product_ID}', [Controllers\CartController::class, 'add'])->name('cart.add');

// Route xóa sản phẩm khỏi giỏ hàng
Route::post('cart/remove/{Product_ID}', [Controllers\CartController::class, 'remove'])->name('cart.remove');

Route::post('cart/update/{Product_ID}', [Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/update-all', [Controllers\CartController::class, 'updateAll'])->name('cart.updateAll');


// Đơn hàng
Route::get('hoa-don/{id}', [Controllers\OrderController::class, 'showhoadon']);

Route::get('huy-don/{id}', [Controllers\OrderController::class, 'huydonhang']);

// 

use App\Http\Controllers\ContactController;

// Hiển thị form liên hệ
Route::get('/contact-form', [ContactController::class, 'show'])->name('contact.show');

// Lưu thông tin liên hệ vào cơ sở dữ liệu
Route::post('/submit-contact', [ContactController::class, 'save'])->name('contact.save');

// Hiển thị danh sách liên hệ
Route::get('/contact-list', [ContactController::class, 'index'])->name('contact.list');



// // ngày 24/10
Route::get('session', function (Request $request) {
    $request->session()->put("cart.products", value: [['id' => 123, 'item' => 5]]);
    $request->session()->push("cart.products", ['id' => 'ABC', 'item' => 7]);

    //  $request ->session()->has('id');

    return redirect()->to('danh-sach');
});

Route::get('laydanhsach', function () {
    $data = DB::table('users')->get();
    print_r($data);
});

