<?php
namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PaymentMethod;
use App\Models\PaymentGateway;
use App\Models\OrderModel as Order;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderMail;
use App\Models\ProfileModel as Profile;

class OrderController extends Controller
{
    public function getOrderDetails($order_id)
    {
   
        $order = OrderModel::with(['orderDetails.product'])->find($order_id);

        if (!$order) {
            return response()->json(['error' => 'Đơn hàng không tồn tại.'], 404);
        }

        // Trả về dữ liệu đơn hàng và chi tiết dưới dạng JSON
        return response()->json([
            'order_id' => $order->order_id,
            'payment' => $order->payment,
            'note' => $order->note,
            'shipping' => $order->shipping,
            'address' => $order->address,
            'orderDetails' => $order->orderDetails->map(function ($detail) {
                return [
                    'orderDetail_id' => $detail->orderDetail_id,
                    'Quantily' => $detail->Quantily,
                    'Price' => $detail->Price,
                    'product' => [
                        'name' => $detail->product ? $detail->product->Name : 'Không có tên sản phẩm',
    
                    ]
                ];
            }),
        ]);
    }


    public function updateShipping(Request $request, $order_id)
    {
        try {
            // Tìm đơn hàng theo ID
            $order = OrderModel::findOrFail($order_id);

            // Cập nhật trạng thái vận chuyển
            $order->shipping = $request->input('shipping');
            $order->save();

            return redirect()->route('order.list')->with('success', 'Cập nhật trạng thái vận chuyển thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái vận chuyển.');
        }
    }
    public function updateStatusAndShipping(Request $request, $order_id)
    {
        // Kiểm tra dữ liệu từ form gửi lên
      
    
        // Tìm đơn hàng theo ID
        $order = OrderModel::find($order_id);
    
        // Kiểm tra nếu đơn hàng không tồn tại
        if (!$order) {
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại!');
        }
    
        // Cập nhật trạng thái thanh toán
        $order->status = $request->input('status');
    
        // Cập nhật trạng thái vận chuyển
        $order->shipping = $request->input('shipping');
        $order->transport = $request->input('transport');
        // Lưu thay đổi vào cơ sở dữ liệu
        $order->save();
    
        // Chuyển hướng về trang danh sách đơn hàng với thông báo thành công
        return redirect()->route('order.list')->with('success', 'Cập nhật trạng thái thành công!');
    }
    
    public function updatePaymentStatus(Request $request, $order_id)
    {
        try {
            // Tìm đơn hàng theo ID
            $order = OrderModel::findOrFail($order_id);

            // Cập nhật trạng thái thanh toán
            $order->status = $request->input('status');
            $order->save();

            return redirect()->route('order.list')->with('success', 'Cập nhật trạng thái thanh toán thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật trạng thái thanh toán.');
        }
    }


    public function orderDetails()
    {
        // Kiểm tra xem có thông tin đơn hàng trong session hay không
        $order = session('order_details');

        if (!$order) {
            return redirect('/cart')->with('error', 'Không có thông tin đơn hàng.');
        }

        return view('order-details', ['order' => $order]);
    }


    public function list(Request $request)
    {
        // Sử dụng join đúng giữa bảng 'order' và 'order_detail'
        $items = OrderModel::join('order_detail', 'order_detail.order_id', '=', 'order.order_id')
            ->select('order.*', 'order_detail.*')
            ->orderBy('order.order_id', 'desc') // Chọn tất cả các trường từ cả hai bảng
            ->get();

        return view('order_list', ['items' => $items]);
    }


    public function showhoadon(Request $request,$id)
    {

        // Sử dụng join đúng giữa bảng 'order' và 'order_detail'
        $items = OrderModel::where('user_id', $id)->with('details.product')->orderBy('order_id', 'desc')->get();

        return view('hoadon_user', ['items' => $items]);
    }
    

    public function checkout(Request $request)
    {
        // Kiểm tra giỏ hàng và người dùng đã đăng nhập
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        $user_id = session('user_id');
        if (!$user_id) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để thanh toán!');
        }

        // Tạo đơn hàng mới
        $order_id = OrderModel::insertGetId([
            'user_id' => $user_id,
            'order_user' => $user_id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'payment_method_id' => PaymentMethod::METHOD_COD,
            'amount' => array_sum(array_map(function ($item) {
                return $item['Price'] * $item['quantity'];
            }, $cart)),
            'shipping' => 'Chờ vận chuyển',
            'status' => PaymentGateway::STATUS_NEW,
            'address' => '',
            'note' => '',
        ]);

        // Lưu chi tiết đơn hàng
        $orderDetails = [];
        foreach ($cart as $productId => $item) {
            $orderDetails[] = [
                'order_id' => $order_id,
                'Product_ID' => $productId,
                'Quantily' => $item['quantity'],
                'Price' => $item['Price'],
            ];
        }

        OrderDetailModel::insert($orderDetails);

        // Lưu thông tin đơn hàng vào session
        $order = OrderModel::with('orderDetails.product')->where('order_id', $order_id)->first();
        session(['order_details' => $order]);

        // Chuyển hướng đến trang chi tiết đơn hàng
        return redirect()->route('order.details')->with('success', 'Đơn hàng của bạn đã được tạo. Vui lòng nhập phương thức thanh toán và ghi chú.');
    }



    // Phương thức xử lý gửi thông tin thanh toán và ghi chú
  

    // public function finalize(Request $request)
    // {
    //     // 1. Kiểm tra giỏ hàng
    //     $cart = session('cart', []);
    //     if (empty($cart)) {
    //         return back()->with('error', 'Giỏ hàng của bạn đang trống!');
    //     }

    //     // 2. Kiểm tra đăng nhập
    //     $user_id = session('user_id');
    //     if (!$user_id) {
    //         return back()->with('error', 'Bạn cần đăng nhập để thanh toán!');
    //     }

    //     // 3. Lấy đơn hàng "Mới đặt hàng"
    //     $order = Order::where('user_id', $user_id)
    //         ->where('status', 'Mới đặt hàng')
    //         ->first();

    //     if (!$order) {
    //         return back()->with('error', 'Không tìm thấy đơn hàng hợp lệ!');
    //     }

    //     // 4. Validate
    //     $request->validate([
    //         'payment_method_id' => 'required|exists:payment_methods,id',
    //         'transport' => 'required|in:hỏa tốc,giao hàng nhanh,tiết kiệm',
    //         'address' => 'required|string|max:255',
    //         'note' => 'nullable|string|max:255',
    //     ]);

    //     try {
    //         // 5. Gán thông tin đơn hàng
    //         $order->payment_method_id = $request->payment_method_id;
    //         $order->transport = $request->transport;
    //         $order->address = $request->address;
    //         $order->note = $request->note;
    //         $order->save();

    //         // 6. Lấy payment method
    //         $paymentMethod = PaymentMethod::find($request->payment_method_id);

    //         // =========================
    //         // COD
    //         // =========================
    //         if ($paymentMethod->id == PaymentMethod::METHOD_COD) {

    //             $order->status = 'Chưa thanh toán';
    //             $order->save();

    //             session()->forget('cart');

    //             return redirect('/cart')->with(
    //                 'success',
    //                 'Đặt hàng thành công! Thanh toán khi nhận hàng.'
    //             );
    //         }

    //         // =========================
    //         // MOMO
    //         // =========================
    //         if ($paymentMethod->id == PaymentMethod::METHOD_MOMO) {

    //             $order->status = 'Chờ thanh toán';
    //             $order->save();

    //             $checkout = app(CheckoutController::class);
    //             $resp = $checkout->createPMGatewayMomo($order);

    //             if (!isset($resp['payUrl'])) {
    //                 return back()->with('error', 'Không thể khởi tạo thanh toán MOMO!');
    //             }

    //             session()->forget('cart');

    //             // redirect sang MOMO
    //             return redirect($resp['payUrl']);
    //         }

    //         return back()->with('error', 'Phương thức thanh toán không hợp lệ!');
    //     } catch (\Exception $e) {
    //         return back()->with('error', $e->getMessage());
    //     }
    // }
    public function finalize(Request $request)
    {
        if (!session('user_id')) {
            return response()->json(['message' => 'Chưa đăng nhập'], 401);
        }

        $order = Order::where('user_id', session('user_id'))
            ->where('status', PaymentGateway::STATUS_NEW)
            ->first();

        if (!$order) {
            return response()->json(['message' => 'Không có đơn hàng'], 404);
        }

        $request->validate([
            'payment_method_id' => 'required',
            'transport' => 'required',
            'address' => 'required',
        ]);

        $order->update($request->only(
            'payment_method_id',
            'transport',
            'address',
            'note'
        ));

        // COD
        if ($request->payment_method_id == PaymentMethod::METHOD_COD) {
            $order->status = PaymentGateway::STATUS_PENDING;
            $order->save();
            session()->forget('cart');
            $profile = Profile::where('user_id', session('user_id'))->first();
            if($profile && $profile->email && filter_var($profile->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($profile->email)->send(new OrderMail($order));
            }
            return response()->json([
                'message' => 'Đặt hàng thành công – Thanh toán khi nhận hàng'
            ]);
        }
        // MOMO
        if ($request->payment_method_id == PaymentMethod::METHOD_MOMO) {
            $order->status = PaymentGateway::STATUS_PENDING;
            $order->save();

            $checkout = app(CheckoutController::class);
            $resp = $checkout->createPMGatewayMomo($order);
            if (!isset($resp['payUrl'])) {
                return response()->json(['message' => 'Không tạo được giao dịch MOMO'], 500);
            }

            session()->forget('cart');

            return response()->json([
                'redirect_url' => $resp['payUrl']
            ]);
        }
        // PayPal
        if ($request->payment_method_id == PaymentMethod::METHOD_PAYPAL) {

            $order->status = 'Chờ thanh toán';
            $order->save();

            $checkout = app(CheckoutController::class);
            $resp = $checkout->createPMGatewayPaypal($order);
            $approveUrl = collect($resp['links'] ?? [])
                ->where('rel', 'approve')
                ->first()['href'] ?? null;

            if (!$approveUrl) {
                return response()->json([
                    'message' => 'Không tạo được giao dịch PayPal'
                ], 500);
            }

            session()->forget('cart');
            $profile = Profile::where('user_id', session('user_id'))->first();
            if($profile && $profile->email && filter_var($profile->email, FILTER_VALIDATE_EMAIL)) {
                Mail::to($profile->email)->send(new OrderMail($order));
            }
            return response()->json([
                'redirect_url' => $approveUrl
            ]);
        }


        return response()->json(['message' => 'Phương thức không hợp lệ'], 400);
    }



    public function remove($order_id, $product_id)
    {
        try {
            // Xóa chi tiết đơn hàng
            OrderDetailModel::where('order_id', $order_id)
                ->where('Product_ID', $product_id)
                ->delete();

            // Kiểm tra nếu không còn chi tiết nào, xóa đơn hàng
            if (OrderDetailModel::where('order_id', $order_id)->count() == 0) {
                OrderModel::where('order_id', $order_id)->delete();
            }

            return redirect()->route('order.list')->with('success', 'Xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra.');
        }
    }

    public function huydonhang(Request $request, $id)
    {
        // Tìm đơn hàng theo ID từ tham số
        $order = OrderModel::find($id);

        if (!$order) {
            // Nếu không tìm thấy đơn hàng, trả về lỗi hoặc thông báo phù hợp
            return redirect()->back()->with('error', 'Đơn hàng không tồn tại!');
        }

        // Lấy ngày hiện tại
        $create_at = Carbon::now();

        // Cập nhật mảng dữ liệu chỉ bao gồm trạng thái và ngày tạo
        $data = [
            'status' => 'hủy đơn',   // Thay đổi trạng thái đơn hàng
            'created_at' => $create_at,  // Cập nhật ngày tạo đơn hàng thành ngày hiện tại
        ];

        // Cập nhật thông tin đơn hàng trong cơ sở dữ liệu
        $order->update($data);

        // Xóa giỏ hàng và thông tin đơn hàng trong session
        session()->forget('Cart');
        session()->forget('order_details');

        // Chuyển hướng đến trang xác nhận đơn hàng
        return redirect()->back();  // Điều chỉnh đường dẫn tới view xác nhận
    }

}
