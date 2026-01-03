<?php
namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            ->select('order.*', 'order_detail.*') // Chọn tất cả các trường từ cả hai bảng
            ->get();

        return view('order_list', ['items' => $items]);
    }


    public function showhoadon(Request $request,$id)
    {

        // Sử dụng join đúng giữa bảng 'order' và 'order_detail'
        $items = OrderModel::where('user_id', $id)->with('details.product')->get();

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
            'payment' => 'Chưa thanh toán',
            'shipping' => 'Chờ vận chuyển',
            'status' => 'Mới đặt hàng',
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
    public function finalize(Request $request)
    {
        // Kiểm tra giỏ hàng trống
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Kiểm tra người dùng đã đăng nhập
        $user_id = session('user_id');
        if (!$user_id) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để thanh toán!');
        }

        // Tìm đơn hàng mới nhất của người dùng với trạng thái "Mới đặt hàng"
        $order = OrderModel::where('user_id', $user_id)
            ->where('status', 'Mới đặt hàng')
            ->first();

        if (!$order) {
            return redirect()->back()->with('error', 'Không tìm thấy đơn hàng hợp lệ!');
        }

        // Xác thực dữ liệu từ form
        $request->validate([
            'payment_method' => 'required|in:tiền mặt,ngân hàng,hủy đơn', // Kiểm tra phương thức thanh toán
            'note' => 'nullable|string|max:255', // Kiểm tra ghi chú
            'transport' => 'required|in:hỏa tốc,giao hàng nhanh,tiết kiệm', // Kiểm tra phương thức vận chuyển
            'address' => 'required|string|max:255', // Kiểm tra địa chỉ giao hàng
            
        ]);

        try {
            // Cập nhật phương thức thanh toán
            $order->payment = $request->input('payment_method'); // Lấy phương thức thanh toán từ form
            $order->note = $request->input('note'); // Lưu ghi chú (nếu có)
            $order->address = $request->input('address'); // Lưu địa chỉ giao hàng (nếu có)
            // Cập nhật phương thức vận chuyển vào trường 'transport'
            $order->transport = $request->input('transport'); // Lưu phương thức vận chuyển vào trường transport

            // Cập nhật trạng thái đơn hàng
            if ($request->input('payment_method') == 'tiền mặt') {
                $order->status = 'Chưa thanh toán'; // Chưa thanh toán nếu chọn tiền mặt
            } else {
                $order->status = 'Đã thanh toán'; // Đã thanh toán nếu chọn ngân hàng
            }

            $order->save(); // Lưu thay đổi vào cơ sở dữ liệu

            // Xóa giỏ hàng sau khi thanh toán
            session()->forget('cart');

            // Lưu thông tin đơn hàng vào session
            session()->put('order_details', $order);

            return redirect('/cart')->with('success', 'Đơn hàng của bạn đã được thanh toán thành công!');
        } catch (\Exception $e) {
            // Xử lý lỗi
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật đơn hàng: ' . $e->getMessage());
        }
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
