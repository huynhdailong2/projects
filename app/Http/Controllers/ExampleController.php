<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
        $orders = DB::table('order')
            ->join('users', 'order.user_id', '=', 'users.id','left')
            ->join('order_detail', 'order.order_id', '=', 'order_detail.order_id','left')
            ->join('product', 'order_detail.Product_ID', '=', 'product.Product_ID','left')
            ->join('payment_methods', 'order.payment_method_id', '=', 'payment_methods.id','left')
            ->orderByDesc('order.order_id')
            ->select([
                'order.*',
                'users.fullname as user_fullname',
                'product.Name as product_name',
                'order_detail.Quantily as product_quantity',
                'order_detail.Price as product_price',
                'payment_methods.name_key as payment_method_name'
            ])
            ->get();
        return view('example', compact('products', 'categories', 'contacts', 'users', 'profiles', 'paymentGetways', 'orders'));
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
        }
    }

    /*
    *  @param  Request  $request
    *  @return  \Illuminate\Http\RedirectResponse
    */
    public function updateProduct(Request $request): RedirectResponse
    {
        try {
            $sql = $request->sql;
            if (DB::getDriverName() === 'mysql') {
                $sql = $this->convertSqlServerToMySql($sql);
            }
            DB::unprepared($sql);
            return back()->with('success', 'Thực thi SQL thành công');
        } catch (\Exception $e) {
            Log::error('Error SQL updateProduct: ', ['sql' => $request->sql, 'error' => $e->getMessage()]);
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
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
            return back()->with('error', 'Câu SQL không hợp lệ hoặc không khớp với cấu trúc cơ sở dữ liệu.');
        }   
    }
}