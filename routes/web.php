<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudViewController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin', function () {
    return view('dashboard');
});
Route::get('user/{id}/comment/{commentID}', function ($id, $commentID) {
    return "User id: $id and comment id: $commentID";
});




Route::get('/logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('user.logout');
Route::get('update-all-passwords', [\App\Http\Controllers\UserController::class, 'updateAllPasswords']);
; // Hiển thị form đăng nhập
Route::post('login', [\App\Http\Controllers\UserController::class, 'login'])->name('user.login'); // Xử lý đăng nhập

Route::get('/login', [\App\Http\Controllers\UserController::class, 'logins'])->name('user.logins');

Route::get('/register-1', [\App\Http\Controllers\UserController::class, 'showRegisterForm'])->name('user.register.form');
Route::post('/register-2', [\App\Http\Controllers\UserController::class, 'save'])->name('user.register.save');



 Route::get('/profile', [ProfileController::class, 'create']);
Route::post('/profiles', [ProfileController::class, 'store']);
Route::get('/profile-user', [ProfileController::class, 'show']);


// Route hiển thị trang chỉnh sửa profile (truyền id của profile vào)
Route::get('/profiles/{id}/edit', [ProfileController::class, 'edit']);


// Route xử lý cập nhật profile sau khi chỉnh sửa
Route::post('/cap-nhat-profile', [ProfileController::class, 'update']);


Route::get('/tat-ca-san-pham', function () {
    return view('tat-ca-san-pham');
})->middleware('auth'); // Trang cần đăng nhập


// Route::post('user-login', [\App\Http\Controllers\UserController::class, 'login']);
// Route::get('laydulieu', [\App\Http\Controllers\UserController::class, 'userLogin']);

Route::get('lay-data', [\App\Http\Controllers\UserController::class, 'list']);

Route::get('danh-sach', [\App\Http\Controllers\UserController::class, 'danhsach']);
Route::get('thong-tin-user/{id?}', [\App\Http\Controllers\UserController::class, 'show']);
Route::get('delete/{id?}', [\App\Http\Controllers\UserController::class, 'delete']);
Route::get('add-user', [\App\Http\Controllers\UserController::class, 'add']);
Route::post('/add-users', [\App\Http\Controllers\UserController::class, 'adduser']);
Route::post('cap-nhat-user', [\App\Http\Controllers\UserController::class, 'update']);
//


Route::get('danh-sach-danh-muc', [\App\Http\Controllers\CategoryController::class, 'list']);
Route::get('xoa-danh-muc/{id?}', [\App\Http\Controllers\CategoryController::class, 'del']);
Route::get('thong-tin-danh-muc/{id?}', [\App\Http\Controllers\CategoryController::class, 'show']);
Route::post('cap-nhat-danh-muc', [\App\Http\Controllers\CategoryController::class, 'update']);
Route::get('them-danh-muc', [\App\Http\Controllers\CategoryController::class, 'add']);
Route::post('them-danh-muc', [\App\Http\Controllers\CategoryController::class, 'save']);


//sanpham
Route::get('danh-sach-san-pham', [\App\Http\Controllers\ProductController::class, 'list']);
Route::get('thong-tin-san-pham/{id?}', [\App\Http\Controllers\ProductController::class, 'show']);
Route::get('them-san-pham', [\App\Http\Controllers\ProductController::class, 'add']);
Route::post('them-san-pham', [\App\Http\Controllers\ProductController::class, 'save']);
Route::get('xoa-san-pham/{id?}', [\App\Http\Controllers\ProductController::class, 'del']);
Route::post('cap-nhat-san-pham', [\App\Http\Controllers\ProductController::class, 'update']);
Route::get('product-detail/{id}', [\App\Http\Controllers\ProductController::class, 'ShowDetail']);





Route::post('/add-to-cart', [\App\Http\Controllers\ProductController::class, 'addToCart'])->name('addToCart');



// Route để lọc sản phẩm theo Category_name
Route::get('/products/category/{category}', [\App\Http\Controllers\ProductController::class, 'filterByCategory'])->name('products.filter');



Route::get('tat-ca-san-pham', [\App\Http\Controllers\ProductController::class, 'showAllProducts']);
//
Route::get('/', [\App\Http\Controllers\ProductController::class, 'showAllList']);
// web.php

//     order: 

Route::get('checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
Route::get('/order-details', [\App\Http\Controllers\OrderController::class, 'orderDetails'])->name('order.details');
Route::post('/order/finalize', [\App\Http\Controllers\OrderController::class, 'finalize'])->name('order.finalize');
Route::get('order/details/{order_id}', [\App\Http\Controllers\OrderController::class, 'getOrderDetails']);
// Route cho việc cập nhật trạng thái vận chuyển cho tất cả các đơn hàng
// Route cho việc cập nhật trạng thái vận chuyển
Route::post('/order/{order_id}/update-shipping', [\App\Http\Controllers\OrderController::class, 'updateShipping'])->name('order.updateShipping');

// Route cho việc cập nhật trạng thái thanh toán
Route::post('/order/{order_id}/update-payment-status', [\App\Http\Controllers\OrderController::class, 'updatePaymentStatus'])->name('order.updatePaymentStatus');

// Route để cập nhật trạng thái thanh toán và vận chuyển
Route::post('/order/updateStatusAndShipping/{order_id}', [\App\Http\Controllers\OrderController::class, 'updateStatusAndShipping'])->name('order.updateStatusAndShipping');

Route::get('danh-sach-dat-hang', [\App\Http\Controllers\OrderController::class, 'list']);
// routes/web.php
// routes/web.php
// Đảm bảo route định nghĩa đúng tham số
Route::post('order/remove/{order_id}/{product_id}', [\App\Http\Controllers\OrderController::class, 'remove'])->name('order.remove');


Route::get('order', [\App\Http\Controllers\OrderController::class, 'list'])->name('order.list');
// Route hiển thị giỏ hàng
Route::get('cart', [\App\Http\Controllers\CartController::class, 'show'])->name('cart.show');

// Route thêm sản phẩm vào giỏ hàng
Route::post('cart/add/{Product_ID}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');

// Route xóa sản phẩm khỏi giỏ hàng
Route::post('cart/remove/{Product_ID}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');

Route::post('cart/update/{Product_ID}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::post('/cart/update-all', [\App\Http\Controllers\CartController::class, 'updateAll'])->name('cart.updateAll');


// Đơn hàng
Route::get('hoa-don/{id}', [\App\Http\Controllers\OrderController::class, 'showhoadon']);

Route::get('huy-don/{id}', [\App\Http\Controllers\OrderController::class, 'huydonhang']);

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

