<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class ExampleController extends Controller
{

    /* 
    *  @return  \Illuminate\View\View
    */
    public function example(): View
    {
        $products = DB::table('product')->orderByDesc('Product_ID')->get();
        $categories = DB::table('category')->orderByDesc('Category_ID')->get();
        $contacts = DB::table('contact')->orderByDesc('contact_id')->get();
        $users = DB::table('users')->orderByDesc('id')->get();
        $profiles = DB::table('profile')->orderByDesc('id_profile')->get();
        $paymentGetways = DB::table('payment_methods')->orderByDesc('id')->get();
        $builder = DB::table('order')
            ->join('users', 'order.user_id', '=', 'users.id', 'left')
            ->join('order_detail', 'order.order_id', '=', 'order_detail.order_id', 'left')
            ->join('product', 'order_detail.Product_ID', '=', 'product.Product_ID', 'left')
            ->join('payment_methods', 'order.payment_method_id', '=', 'payment_methods.id', 'left')
            ->orderByDesc('order.order_id')
            ->select([
                'order.*',
                'users.fullname as user_fullname',
                'product.Name as product_name',
                'order_detail.Quantily as order_quantity',
                'product.Quantily as product_quantity',
                'order_detail.Price as product_price',
                'payment_methods.name_key as payment_method_name'
            ]);
        $orders = $builder->get();
        $orderCheckouts = $builder->get();
        return view('example', compact('products', 'categories', 'contacts', 'users', 'profiles', 'paymentGetways', 'orders', 'orderCheckouts'));
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storeProduct(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storeProduct: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateProduct(Request $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $productId = (int) $request->product_id;
            $newPrice  = (float) $request->new_price;
            $userId    = (int) $request->user_id;
            $reason    = $request->reason;
            if (!DB::table('users')->where('id', $userId)->exists()) {
                throw new \Exception('User không tồn tại');
            }
            $product = DB::table('product')
                ->where('Product_ID', $productId)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw new \Exception('Sản phẩm không tồn tại');
            }
            if ($newPrice <= 0) {
                throw new \Exception('Giá mới phải lớn hơn 0');
            }

            if ($newPrice == $product->Price) {
                throw new \Exception('Giá mới giống giá cũ, không cần cập nhật');
            }
            $percentChange = (($newPrice - $product->Price) / $product->Price) * 100;
            DB::table('product')
                ->where('Product_ID', $productId)
                ->update([
                    'Price' => $newPrice
                ]);
            $dataLog = [
                'product_id' => $productId,
                'old_price'  => $product->Price,
                'new_price'  => $newPrice,
                'percent'    => $percentChange,
                'reason'     => $reason,
                'user_id'    => $userId,
                'created_at' => now()
            ];
            Log::info('updateProduct Data log', $dataLog);
            DB::commit();
            return back()->with('success', 'Cập nhật giá thành công')
                ->with('updateProductId', $productId)
                ->with('updateNewPrice', $newPrice)
                ->with('updateUserId', $userId)
                ->with('updateReason', $reason);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('updateProduct error', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }


    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deleteProduct(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deleteProduct: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storeCategory(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storeCategory: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateCategory(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updateCategory: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deleteCategory(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deleteCategory: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storeContact(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storeContact: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateContact(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updateContact: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deleteContact(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deleteContact: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storeUser(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            $parsed = $this->parseInsertSql($sql);
            if ($parsed['table'] !== 'users') {
                return back()->with('error', 'Chỉ cho phép table users');
            }
            $data = array_combine($parsed['columns'], $parsed['values']);
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            DB::table('users')->insert($data);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storeUser', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateUser(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            $parsed = $this->parseUpdateSql($sql);
            if ($parsed['table'] !== 'users') {
                return back()->with('error', 'Chỉ cho phép table users');
            }
            $data = array_combine($parsed['columns'], $parsed['values']);
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            DB::table('users')->where($parsed['whereColumn'], $parsed['whereValue'])->update($data);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updateUser', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deleteUser(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deleteUser: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storeProfile(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storeProfile: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateProfile(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updateProfile: ', ['sql'   => $request->sql, 'error' => $e->getMessage(),]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deleteProfile(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deleteProfile: ', ['sql'   => $request->sql, 'error' => $e->getMessage(),]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storePaymentGetway(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storePaymentGetway: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updatePaymentGetway(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updatePaymentGetway: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deletePaymentGetway(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deletePaymentGetway: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function storeOrder(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;

            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL storeOrder', ['sql'   => $request->sql, 'error' => $e->getMessage(),]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }


    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateOrder(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updateOrder: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function deleteOrder(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL deleteOrder: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra')->with('activeTab', 'deleteOrder');
        }
    }

    public function checkSql(Request $request): string
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL checkSql: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Đã có lỗi xảy ra')->with('activeTab', 'checkSql');
        }
    }

    public function storeCheckout(Request $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $userId = $request->user_id;
            $productId = $request->Product_ID;
            $quantity = $request->Quantity;
            $payment_method_id = $request->payment_method_id;
            $transport = $request->transport;
            $address = $request->address;

            $userExists = DB::table('users')->where('id', $userId)->exists();
            if (!$userExists) {
                throw new \Exception('User không tồn tại');
            }

            $product = DB::table('product')->where('Product_ID', $productId)->lockForUpdate()->first();
            if (!$product) {
                throw new \Exception('Sản phẩm không tồn tại');
            }

            if ($quantity > $product->Quantily) {
                throw new \Exception('Số lượng mua vượt quá tồn kho');
            }

            $orderId = DB::table('order')->insertGetId([
                'user_id' => $userId,
                'payment_method_id' => $payment_method_id,
                'shipping' => 'Chờ vận chuyển',
                'transport' => $transport,
                'status' => 'PENDING',
                'order_user' => $userId,
                'address' => $address,
            ]);

            DB::table('order_detail')->insert([
                'order_id' => $orderId,
                'Product_ID' => $productId,
                'Quantily' => $quantity,
                'Price' => $product->Price,
            ]);

            DB::table('product')
                ->where('Product_ID', $productId)
                ->update([
                    'Quantily' => DB::raw('Quantily - ' . $quantity)
                ]);

            DB::table('order')
                ->where('order_id', $orderId)
                ->update([
                    'amount' => DB::raw("
                        (SELECT SUM(Quantily * Price)
                        FROM order_detail
                        WHERE order_id = {$orderId})
                    ")
                ]);

            DB::commit();
            return back()->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'checkout')
                ->with('userIdCheckout', $userId)
                ->with('productIdCheckout', $productId)
                ->with('quantityCheckout', $quantity)
                ->with('paymentMethodIdCheckout', $payment_method_id)
                ->with('transportCheckout', $transport)
                ->with('addressCheckout', $address);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi tạo đơn hàng')->with('activeTab', 'checkout');
        }
    }
    public function reportProduct(Request $request): RedirectResponse
    {
        try {
            $minSold = (int) $request->min_sold;

            $reports = DB::table('product as p')
                ->join('order_detail as od', 'p.Product_ID', '=', 'od.Product_ID')
                ->selectRaw("
                    p.Product_ID,
                    p.Name,
                    p.Price,
                    CAST(p.Quantily AS SIGNED) AS TonKho,
                    SUM(od.Quantily) AS TongSoLuongDaBan,
                    CASE 
                        WHEN SUM(od.Quantily) >= 10 THEN 'Bán chạy'
                        WHEN SUM(od.Quantily) >= 5 THEN 'Bán khá'
                        ELSE 'Bán ít'
                    END AS MucDoBan,
                    CASE 
                        WHEN CAST(p.Quantily AS SIGNED) < 10 THEN 'Tồn kho thấp'
                        ELSE 'Bình thường'
                    END AS TrangThaiKho
                ")
                ->groupBy('p.Product_ID', 'p.Name', 'p.Price', 'p.Quantily')
                ->havingRaw('SUM(od.Quantily) >= ?', [$minSold])
                ->orderByDesc('TongSoLuongDaBan')
                ->get();

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'reportProduct')
                ->with('reports', $reports)
                ->with('minSold', $minSold);
        } catch (\Exception $e) {
            Log::error('Error reportProduct', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi tạo báo cáo sản phẩm')->with('activeTab', 'reportProduct');
        }
    }
    public function checkOrder(Request $request): RedirectResponse
    {
        try {
            $highAmount = (float) $request->high_amount;

            $checkOrders = DB::table(DB::raw('`order` as o'))
                ->join('users as u', 'o.user_id', '=', 'u.id')
                ->selectRaw("
                    o.order_id,
                    u.fullname AS TenKhachHang,
                    o.amount AS GiaTriDonHang,
                    o.status,
                    o.created_at,
                    CASE
                        WHEN o.amount >= ? THEN 'Đơn giá trị cao'
                        WHEN o.status = 'CANCELED' THEN 'Đơn bị hủy'
                        WHEN EXISTS (
                            SELECT 1 FROM `order` o2
                            WHERE o2.user_id = o.user_id
                            AND TIMESTAMPDIFF(MINUTE, o2.created_at, o.created_at) <= 10
                            AND o2.order_id <> o.order_id
                        ) THEN 'Nhiều đơn trong thời gian ngắn'
                        ELSE 'Bình thường'
                    END AS LyDoCanhBao
                ", [$highAmount])
                ->whereNotNull('o.amount')
                ->where(function ($q) use ($highAmount) {
                    $q->where('o.amount', '>=', $highAmount)
                        ->orWhere('o.status', 'CANCELED');
                })
                ->orderByDesc('o.created_at')
                ->get();

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'checkorder')
                ->with('checkOrders', $checkOrders)
                ->with('highAmount', $highAmount);
        } catch (\Exception $e) {
            Log::error('checkOrder error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi kiểm tra đơn hàng')->with('activeTab', 'checkorder');
        }
    }
    public function reportRevenue(): RedirectResponse
    {
        try {
            $revuneReports = DB::table('order')
                ->selectRaw("
                YEAR(created_at) AS Nam,
                MONTH(created_at) AS Thang,
                COUNT(order_id) AS SoLuongDon,
                SUM(amount) AS TongDoanhThu,
                AVG(amount) AS TrungBinhMoiDon
            ")
                ->where('status', 'PAID')
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByDesc('Nam')
                ->orderByDesc('Thang')
                ->get();

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'reportRevenue')
                ->with('revuneReports', $revuneReports);
        } catch (\Exception $e) {
            Log::error('reportRevenue error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi tạo báo cáo doanh thu')->with('activeTab', 'reportRevenue');
        }
    }
    public function reportVipCustomer(): RedirectResponse
    {
        try {
            $vipCustomers = DB::table('users as u')
                ->join('order as o', 'u.id', '=', 'o.user_id', 'left')
                ->selectRaw("
                u.id AS UserID,
                u.fullname AS TenKhachHang,
                COUNT(o.order_id) AS TongSoDonHang,
                COALESCE(SUM(o.amount), 0) AS TongTienDaChi,
                MAX(o.created_at) AS LanMuaGanNhat,
                CASE
                    WHEN SUM(o.amount) >= 100 THEN 'Khách VIP'
                    WHEN SUM(o.amount) >= 50 THEN 'Khách tiềm năng'
                    ELSE 'Khách thường'
                END AS HangKhachVIP
            ")
                ->groupBy('u.id', 'u.fullname')
                ->orderByDesc('TongTienDaChi')
                ->get();

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'reportUser')
                ->with('vipCustomers', $vipCustomers);
        } catch (\Exception $e) {
            Log::error('reportVipCustomer error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi tạo báo cáo khách hàng VIP')->with('activeTab', 'reportUser');
        }
    }
    public function cancelOrder(Request $request): RedirectResponse
    {
        DB::beginTransaction();

        try {
            $orderId = (int) $request->order_id;
            $order = DB::table('order')
                ->where('order_id', $orderId)
                ->lockForUpdate()
                ->first();
            if (!$order) {
                throw new \Exception('Đơn hàng không tồn tại');
            }

            if ($order->status === 'CANCELED') {
                throw new \Exception('Đơn hàng đã bị hủy trước đó');
            }
            DB::table('order')
                ->where('order_id', $orderId)
                ->update([
                    'status' => 'CANCELED',
                    'shipping' => 'Đơn hàng đã bị hủy',
                    'updated_at' => now(),
                ]);

            $orderDetails = DB::table('order_detail')
                ->where('order_id', $orderId)
                ->get();
            $result = [];
            foreach ($orderDetails as $detail) {
                DB::table('product')
                    ->where('Product_ID', $detail->Product_ID)
                    ->lockForUpdate()
                    ->update([
                        'Quantily' => DB::raw('Quantily + ' . (int) $detail->Quantily)
                    ]);
                $product = DB::table('product')
                    ->where('Product_ID', $detail->Product_ID)
                    ->first();

                $result[] = (object)[
                    'Product_ID'      => $product->Product_ID,
                    'Product_Name'    => $product->Name,
                    'SoLuongHoan'     => $detail->Quantily,
                    'TonKhoSauHoan'   => $product->Quantily,
                    'ThoiGianHoanKho' => now(),
                    'ThongBao'        => 'HOÀN KHO THÀNH CÔNG',
                ];
            }

            DB::commit();
            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('orderIdCancel', $orderId)
                ->with('cancelOrders', $result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('cancelOrder error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi hủy đơn hàng')->with('activeTab', 'cancelorder');
        }
    }
    public function inventoryAlert(Request $request): RedirectResponse
    {
        try {
            $threshold = (int) $request->threshold;
            $products = DB::table('product')
                ->whereRaw('CAST(Quantily AS SIGNED) <= ?', [$threshold])
                ->get()
                ->map(fn($p) => (object)[
                    'Product_ID'      => $p->Product_ID,
                    'Name'            => $p->Name,
                    'TonKhoHienTai'   => (int) $p->Quantily,
                    'MucDoCanhBao'    => 'RẤT THẤP',
                    'ThoiGianCanhBao' => now(),
                    'ThongBao'        => 'CẢNH BÁO TỒN KHO THẤP',
                ]);
            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'inventoryAlert')
                ->with('inventoryAlerts', $products)
                ->with('threshold', $threshold);
        } catch (\Exception $e) {
            Log::error('inventoryAlert error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi kiểm tra cảnh báo tồn kho')->with('activeTab', 'inventoryAlert');
        }
    }
    public function checkPassword(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[^a-zA-Z0-9]/'
            ],
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Mật khẩu phải có chữ hoa, chữ thường, số và ký tự đặc biệt');
        }
        if (DB::table('users')->where('username', $request->username)->exists()) {
            return back()->with('error', 'Username đã tồn tại');
        }
        try {
            if (stripos($request->password, $request->username) !== false) {
                return back()->with('error', 'Mật khẩu không được chứa username');
            }
            $userId = DB::table('users')->insertGetId([
                'username' => $request->username,
                'fullname' => $request->fullname,
                'password' => Hash::make($request->password),
            ]);

            $userCheck = DB::table('users')->where('id', $userId)->first();

            return back()->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'hashPassword')
                ->with('userCheck', $userCheck)
                ->with('usernameCheck', $request->username)
                ->with('fullnameCheck', $request->fullname)
                ->with('passwordCheck', $request->password);
        } catch (\Exception $e) {
            Log::error('checkPassword error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Có lỗi khi tạo user')->with('activeTab', 'hashPassword');
        }
    }
    public function birthdayDiscount(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|integer',
            'birthday'   => 'required|date',
            'order_id'   => 'required|integer',
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Dữ liệu đầu vào không hợp lệ');
        }
        try {
            DB::beginTransaction();
            DB::table('profile')
                ->where('user_id', $request->user_id)
                ->update([
                    'birthday' => $request->birthday
                ]);
            DB::table('order_detail')->insert([
                'order_id'   => $request->order_id,
                'Product_ID' => $request->product_id,
                'Quantily'   => $request->quantity,
                'Price'      => $request->price,
            ]);
            $result = DB::table('users')
                ->join('order', 'users.id', '=', 'order.user_id')
                ->select(
                    'users.id as user_id',
                    'users.username',
                    'users.fullname',
                    'order.order_id',
                    'order.amount'
                )
                ->where('order.order_id', $request->order_id)
                ->first();
            DB::commit();
            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'promotionUser')
                ->with('discountResult', $result)
                ->with('userIdDiscount', $request->user_id)
                ->with('birthdayDiscount', $request->birthday)
                ->with('orderIdDiscount', $request->order_id)
                ->with('productIdDiscount', $request->product_id)
                ->with('quantityDiscount', $request->quantity)
                ->with('priceDiscount', $request->price);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('birthdayDiscount error', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Có lỗi khi chạy Birthday Discount')->with('activeTab', 'promotionUser');
        }
    }
    public function promotionSpecialDay(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id'   => 'required|integer',
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
            'price'      => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return back()->with('error', 'Dữ liệu đầu vào không hợp lệ');
        }
        try {
            DB::beginTransaction();
            DB::table('order_detail')->insert([
                'order_id'   => $request->order_id,
                'Product_ID' => $request->product_id,
                'Quantily'   => $request->quantity,
                'Price'      => $request->price,
            ]);
            $discountResult = DB::table('order as o')
                ->join('users as u', 'o.user_id', '=', 'u.id')
                ->select(
                    'u.id as user_id',
                    'u.username',
                    'u.fullname',
                    'o.order_id',
                    'o.amount'
                )
                ->where('o.order_id', $request->order_id)
                ->first();

            DB::commit();

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'promotionSpecialDay')
                ->with('promotionSpecialDayResult', $discountResult)
                ->with('orderIdSpecialDay', $request->order_id)
                ->with('productIdSpecialDay', $request->product_id)
                ->with('quantitySpecialDay', $request->quantity)
                ->with('priceSpecialDay', $request->price);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('specialDayDiscount error', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Có lỗi khi chạy khuyến mãi ngày đặc biệt')->with('activeTab', 'promotionSpecialDay');
        }
    }
    public function promotionWeekly(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'test_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Dữ liệu đầu vào không hợp lệ');
        }

        try {
            $sql = "
                SELECT
                    o.order_id,
                    ? AS NgayTest,

                    p.Product_ID,
                    p.Name AS TenSanPham,
                    CAST(p.Quantily AS SIGNED) AS TonKho,

                    od.Quantily AS SoLuongMua,
                    od.Price AS GiaGoc,

                    CASE
                        WHEN CAST(p.Quantily AS SIGNED) > 300
                            AND DAYOFWEEK(?) = 1
                        THEN od.Price * 0.5
                        ELSE od.Price
                    END AS GiaSauGiam,

                    od.Price -
                    CASE
                        WHEN CAST(p.Quantily AS SIGNED) > 300
                            AND DAYOFWEEK(?) = 1
                        THEN od.Price * 0.5
                        ELSE od.Price
                    END AS GiamTren1SanPham,

                    od.Quantily * od.Price AS ThanhTienGiaGoc,

                    od.Quantily *
                    CASE
                        WHEN CAST(p.Quantily AS SIGNED) > 300
                            AND DAYOFWEEK(?) = 1
                        THEN od.Price * 0.5
                        ELSE od.Price
                    END AS ThanhTienSauGiam,

                    (od.Quantily * od.Price) -
                    (od.Quantily *
                        CASE
                            WHEN CAST(p.Quantily AS SIGNED) > 300
                                AND DAYOFWEEK(?) = 1
                            THEN od.Price * 0.5
                            ELSE od.Price
                        END
                    ) AS TongTienGiam,

                    CASE
                        WHEN CAST(p.Quantily AS SIGNED) > 300
                            AND DAYOFWEEK(?) = 1
                        THEN 'Giảm Chủ Nhật do tồn kho cao'
                        ELSE 'Không giảm'
                    END AS LyDoGiam

                FROM order_detail od
                JOIN `order` o ON od.order_id = o.order_id
                JOIN product p ON od.Product_ID = p.Product_ID
                ORDER BY TongTienGiam DESC
            ";
            $date = $request->test_date;
            $results = DB::select($sql, [
                $date,
                $date,
                $date,
                $date,
                $date,
                $date
            ]);

            return back()
                ->with('success', 'Truy vấn MySQL thành công')
                ->with('activeTab', 'promotionWeekly')
                ->with('weeklyPromotionResults', $results)
                ->with('testDateWeekly', $date);
        } catch (\Exception $e) {
            Log::error('weeklyPromotion error', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Đã xảy ra lỗi')->with('activeTab', 'promotionWeekly');
        }
    }
    public function totalProductPrice(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Dữ liệu đầu vào không hợp lệ');
        }

        try {
            $result = DB::selectOne(
                "
            SELECT 
                od.order_id,
                IFNULL(SUM(od.Quantily * od.Price), 0) AS TongTienDonHang
            FROM order_detail od
            WHERE od.order_id = ?
            GROUP BY od.order_id
            ",
                [$request->order_id]
            );

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'totalProductPrice')
                ->with('totalProductPriceResult', $result)
                ->with('orderIdProductPrice', $request->order_id);
        } catch (\Exception $e) {
            Log::error('totalProductPrice error', ['error' => $e->getMessage()]);
            return back()
                ->with('error', 'Có lỗi khi tính tổng tiền đơn hàng')
                ->with('activeTab', 'totalProductPrice');
        }
    }
    public function totalProductByCategory(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Dữ liệu đầu vào không hợp lệ');
        }

        try {
            $result = DB::selectOne(
                "
            SELECT 
                p.cate_id AS Category_ID,
                IFNULL(SUM(CAST(p.Quantily AS SIGNED)), 0) AS TongSoLuong
            FROM product p
            WHERE p.cate_id = ?
            GROUP BY p.cate_id
            ",
                [$request->category_id]
            );

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'totalProductByCategory')
                ->with('totalProductQuantityResult', $result)
                ->with('categoryIdProductQuantity', $request->category_id);
        } catch (\Exception $e) {
            Log::error('totalProductByCategory error', ['error' => $e->getMessage()]);

            return back()
                ->with('error', 'Có lỗi khi tính tổng sản phẩm theo danh mục')
                ->with('activeTab', 'totalProductByCategory');
        }
    }
    public function monthlyRevenueReportCursor(Request $request): RedirectResponse
    {
        try {
            $revenues = DB::table(DB::raw('`order`'))
                ->selectRaw("
                YEAR(created_at) AS Nam,
                MONTH(created_at) AS Thang,
                COUNT(order_id) AS SoLuongDon,
                SUM(amount) AS TongDoanhThu,
                AVG(amount) AS TrungBinhMoiDon
            ")
                ->where('status', 'PAID')
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderByDesc('Nam')
                ->orderByDesc('Thang')
                ->cursor();

            $results = [];
            foreach ($revenues as $row) {
                $results[] = $row;
            }

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'monthlyRevenueReport_Cursor')
                ->with('monthlyRevenueCursorResults', $results);
        } catch (\Exception $e) {
            Log::error('monthlyRevenueReportCursor error', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->with('error', 'Có lỗi khi tạo báo cáo doanh thu theo cursor')
                ->with('activeTab', 'monthlyRevenueReport_Cursor');
        }
    }
    public function bestSellingProducts(Request $request): RedirectResponse
    {
        try {
            $results = DB::select("
            SELECT
                p.Product_ID,
                p.Name AS TenSanPham,
                IFNULL(SUM(od.Quantily), 0) AS TongSoLuongDaBan,

                CASE
                    WHEN IFNULL(SUM(od.Quantily), 0) >= 10 THEN 'BÁN CHẠY'
                    WHEN IFNULL(SUM(od.Quantily), 0) >= 5 THEN 'BÁN TRUNG BÌNH'
                    ELSE 'BÁN CHẬM'
                END AS XepLoai

            FROM product p
            LEFT JOIN order_detail od
                ON p.Product_ID = od.Product_ID

            GROUP BY p.Product_ID, p.Name
            ORDER BY TongSoLuongDaBan DESC
        ");

            return back()
                ->with('success', 'Thực thi SQL thành công')
                ->with('activeTab', 'Best_selling_products')
                ->with('bestSellingProductsResults', $results);
        } catch (\Exception $e) {
            Log::error('bestSellingProducts error', [
                'error' => $e->getMessage()
            ]);

            return back()
                ->with('error', 'Có lỗi khi thống kê sản phẩm bán chạy')
                ->with('activeTab', 'Best_selling_products');
        }
    }
}
