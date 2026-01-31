<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\OrderDetailModel;
use App\Models\OrderModel;


class CartController extends Controller
{


    public function updateAll(Request $request)
    {
        // Lấy giỏ hàng từ session
        $cart = $request->session()->get('cart', []);
        // Lấy dữ liệu cập nhật từ request
        $updatedCart = $request->input('cart', []);
    
        foreach ($updatedCart as $id => $data) {
            if (isset($cart[$id])) {
                $product = ProductModel::where('Product_ID', $id)->first();
                if(empty($product->Quantity) && $product->Quantity <= $data['quantity']){ 
                    unset($cart[$id]);
                    continue;
                }
                $quantity = max(1, intval($data['quantity'])); // Đảm bảo số lượng >= 1
                $cart[$id]['quantity'] = $quantity;
                // Kiểm tra dữ liệu sản phẩm có đầy đủ không
                if (empty($cart[$id]['Name']) || empty($cart[$id]['Img']) || empty($cart[$id]['Price'])) {
                    unset($cart[$id]); // Xóa sản phẩm nếu dữ liệu không hợp lệ
                }
            }
        }
        
    
        // Lưu lại giỏ hàng vào session
        $request->session()->put('cart', $cart);
    
        // Xử lý khi giỏ hàng trống
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('info', 'Giỏ hàng của bạn đang trống!');
        }
    
        return redirect()->route('cart.show')->with('success', 'Giỏ hàng đã được cập nhật!');
    }
    

    public function add(Request $request, $id)
    {
        try {
            // Lấy thông tin sản phẩm từ database với Product_ID
            $product = ProductModel::where('Product_ID', $id)->firstOrFail();
            if (empty($product->Name) || empty($product->Img)) {
                return redirect()->back()->with('error', 'Sản phẩm này không khả dụng!');
            }
            
        
            // Lấy giỏ hàng hiện tại từ session
            $cart = $request->session()->get('cart', []);
        
            // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
            if (isset($cart[$product->Product_ID])) {
                // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng lên 1
                $cart[$product->Product_ID]['quantity'] += 1; 
            } else {
                // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm vào giỏ hàng
                $cart[$product->Product_ID] = [
                    'Name' => $product->Name ?? 'Tên không xác định',
                    'Price' => $product->Price ?? 0,
                    'Img' => $product->Img ?? 'default_image.jpg',
                    'Quantily' => $product->Quantily ?? 0,
                    'quantity' => 1
                ];
                
            }
        
            // Lưu lại giỏ hàng vào session
            $request->session()->put('cart', $cart);
        
            // Trả về thông báo thành công
            return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
        } catch (\Exception $e) {
            // Trả về thông báo lỗi nếu có
            return redirect()->back()->with('error', 'Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.');
        }
    }
    

    public function update(Request $request, $id)
{
    // Lấy giỏ hàng hiện tại từ session
    $cart = $request->session()->get('cart', []);

    // Kiểm tra xem sản phẩm có trong giỏ hàng không
    if (isset($cart[$id])) {
        // Cập nhật số lượng mới
        $quantity = $request->input('quantity', 1); // Mặc định là 1 nếu không có giá trị
        $cart[$id]['quantity'] = $quantity;
    }

    // Lưu lại giỏ hàng vào session
    $request->session()->put('cart', $cart);

    return redirect()->route('cart.show')->with('success', 'Số lượng sản phẩm đã được cập nhật!');
}
public function show(Request $request)
{
    // Lấy thông tin giỏ hàng từ session
    $cart = $request->session()->get('cart', []);

    // Tính tổng giá tiền
    $total = array_reduce($cart, function ($sum, $item) {
        // Kiểm tra sự tồn tại của Price và quantity, nếu không có thì lấy giá trị mặc định là 0
        $price = $item['Price'] ?? 0;
        $quantity = $item['quantity'] ?? 1; // Mặc định là 1 nếu không có giá trị

        return $sum + ($price * $quantity);
    }, 0);
    $totalProducts = count($cart);

    return view('cart', [
        'cart' => $cart,
        'total' => $total,
        'totalProducts' => $totalProducts, // Số lượng sản phẩm dựa trên product_id
    ]);
 
}


    
   
    // Xóa sản phẩm khỏi giỏ hàng
    public function remove(Request $request, $id)
    {
        // Lấy giỏ hàng từ session
        $cart = $request->session()->get('cart', []);
    
      
        
        // Kiểm tra sản phẩm có tồn tại trong giỏ hàng không
        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa sản phẩm
            $request->session()->put('cart', $cart); // Lưu lại session
            
            if (empty($cart)) {
                return redirect()->route('cart.show')->with('info', 'Giỏ hàng của bạn đang trống!');
            }
            return redirect()->route('cart.show')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
        }
        return redirect()->route('cart.show')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
    }
    
    
    
}
