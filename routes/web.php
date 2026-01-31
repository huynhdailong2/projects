<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers;
use App\Http\Controllers\API;

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/admin', function () {
//     return view('dashboard');
// })->middleware('admin');
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('admin.dashboard');
    Route::get('danh-sach-san-pham', [Controllers\ProductController::class, 'list'])->name('admin.products.list');
    Route::get('danh-sach-danh-muc', [Controllers\CategoryController::class, 'list'])->name('admin.categories.list');
    Route::get('danh-sach-dat-hang', [Controllers\OrderController::class, 'list'])->name('admin.orders.list');
    Route::get('danh-sach-lien-he', [Controllers\ContactController::class, 'index'])->name('admin.contacts.list');
    Route::get('danh-sach-nguoi-dung', [Controllers\UserController::class, 'danhsach'])->name('admin.users.list');
    Route::get('danh-sach-thanh-toan', [Controllers\PaymentGatewayController::class, 'list'])->name('admin.payment.list');
    Route::get('payments/{id}/request', [Controllers\PaymentGatewayController::class, 'paymentRequest'])->name('admin.payments.request');
    Route::get('lay-data', [Controllers\UserController::class, 'list']);
    Route::get('thong-tin-user/{id?}', [Controllers\UserController::class, 'show']);
    Route::get('delete/{id?}', [Controllers\UserController::class, 'delete']);
    Route::get('add-user', [Controllers\UserController::class, 'add']);
    Route::post('/add-users', [Controllers\UserController::class, 'adduser']);
    Route::post('cap-nhat-user', [Controllers\UserController::class, 'update']);
    Route::get('xoa-danh-muc/{id?}', [Controllers\CategoryController::class, 'del']);
    Route::get('thong-tin-danh-muc/{id?}', [Controllers\CategoryController::class, 'show']);
    Route::post('cap-nhat-danh-muc', [Controllers\CategoryController::class, 'update']);
    Route::get('them-danh-muc', [Controllers\CategoryController::class, 'add']);
    Route::post('them-danh-muc', [Controllers\CategoryController::class, 'save']);

    Route::get('thong-tin-san-pham/{id?}', [Controllers\ProductController::class, 'show']);
    Route::get('them-san-pham', [Controllers\ProductController::class, 'add']);
    Route::post('them-san-pham', [Controllers\ProductController::class, 'save']);
    Route::get('xoa-san-pham/{id?}', [Controllers\ProductController::class, 'del']);
    Route::post('cap-nhat-san-pham', [Controllers\ProductController::class, 'update']);
    Route::get('product-detail/{id}', [Controllers\ProductController::class, 'ShowDetail']);
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
Route::get('/forgot-password', [Controllers\Auth\ForgotPasswordController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [Controllers\Auth\ForgotPasswordController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [Controllers\Auth\ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [Controllers\Auth\ForgotPasswordController::class, 'resetPassword'])->name('password.update');


Route::get('/logout', [Controllers\UserController::class, 'logout'])->name('user.logout');
Route::get('update-all-passwords', [Controllers\UserController::class, 'updateAllPasswords']);; // Hiển thị form đăng nhập
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

// ExampleController routes
Route::get('sql/queries', [Controllers\ExampleController::class, 'example']);

//product
Route::prefix('product')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storeProduct'])->name('product.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updateProduct'])->name('product.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deleteProduct'])->name('product.delete');
    Route::post('/report', [Controllers\ExampleController::class, 'reportProduct'])->name('product.report');
    Route::post('/total-product-price', [Controllers\ExampleController::class, 'totalProductPrice'])->name('user.totalProductPrice');
    Route::post('/total-product-by-category', [Controllers\ExampleController::class, 'totalProductByCategory'])->name('user.totalProductByCategory');
});

//category
Route::prefix('category')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storeCategory'])->name('category.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updateCategory'])->name('category.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deleteCategory'])->name('category.delete');
});

//contact
Route::prefix('contact')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storeContact'])->name('contact.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updateContact'])->name('contact.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deleteContact'])->name('contact.delete');
});

//user
Route::prefix('user')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storeUser'])->name('user.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updateUser'])->name('user.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deleteUser'])->name('user.delete');
    Route::post('/report', [Controllers\ExampleController::class, 'reportVipCustomer'])->name('user.reportVip');
    Route::post('/birthday-discount', [Controllers\ExampleController::class, 'birthdayDiscount'])->name('user.birthdayDiscount');
    Route::post('/promotion-special-day', [Controllers\ExampleController::class, 'promotionSpecialDay'])->name('user.promotionSpecialDay');
    Route::post('/promotion-weekly', [Controllers\ExampleController::class, 'promotionWeekly'])->name('user.promotionWeekly');
});

//profile
Route::prefix('profile')->group(function () {
    Route::get('/store', [Controllers\ExampleController::class, 'storeProfile'])->name('profile.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updateProfile'])->name('profile.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deleteProfile'])->name('profile.delete');
});

//paymentgetway
Route::prefix('paymentgetway')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storePaymentGetway'])->name('paymentgetway.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updatePaymentGetway'])->name('paymentgetway.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deletePaymentGetway'])->name('paymentgetway.delete');
});

//order
Route::prefix('order')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storeOrder'])->name('order.store');
    Route::post('/update', [Controllers\ExampleController::class, 'updateOrder'])->name('order.update');
    Route::post('/delete', [Controllers\ExampleController::class, 'deleteOrder'])->name('order.delete');
    Route::post('/check', [Controllers\ExampleController::class, 'checkOrder'])->name('order.check');
    Route::post('/cancel', [Controllers\ExampleController::class, 'cancelOrder'])->name('order.cancel');
});

//checkout
Route::prefix('checkout')->group(function () {
    Route::post('/store', [Controllers\ExampleController::class, 'storeCheckout'])->name('checkout.store');
});
Route::prefix('report')->group(function () {
    Route::post('/revenue', [Controllers\ExampleController::class, 'reportRevenue'])->name('report.revenue');
    Route::post('/revenue-average', [Controllers\ExampleController::class, 'reportRevenueAverage'])->name('report.revenueAverage');
});
Route::post('inventory-alert', [Controllers\ExampleController::class, 'inventoryAlert'])->name('inventory.alert');
Route::post('check-password', [Controllers\ExampleController::class, 'checkPassword'])->name('check.password');
Route::post('monthly-revenue-report-cursor', [Controllers\ExampleController::class, 'monthlyRevenueReportCursor'])->name('monthly.revenue.report.cursor');
Route::post('best-selling-products', [Controllers\ExampleController::class, 'bestSellingProducts'])->name('best.selling.products');
