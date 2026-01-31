<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;
use App\Models\ProfileModel as Profile;

class UserController extends Controller
{

    public function adduser(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'txt_username' => 'required|string|unique:users,username|max:255',
            'txt_password' => 'required|string|min:3',
            'txt_fullname' => 'required|string|max:255',
        ]);

        try {
            // Tạo user mới
            UserModel::create([
                'username' => $request->txt_username,
                'password' => Hash::make($request->txt_password),
                'fullname' => $request->txt_fullname,
            ]);

            return redirect()->back()->with('success', 'Thêm người dùng thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage())
                ->withInput();
        }
    }
    // Hiển thị danh sách người dùng
    public function danhsach(Request $request)
    {
        $users = UserModel::all();
        // $info_user = $request->session()->get('username');
        // $cart = $request->session()->get('cart.products');
        return view('list', ['users' => $users]);
    }

    // Hiển thị thông tin chi tiết người dùng
    public function show($id)
    {
        $user = UserModel::where('id', $id)->get();
        return view('info_user', ['user' => $user]);
    }

    // Cập nhật thông tin người dùng
    public function update(Request $request)
    {
        $id = $request->input("txt_id");
        $name = $request->input("txt_username");
        $fullname = $request->input("txt_fullname");
        $password = Hash::make($request->input("txt_password"));
        UserModel::where('id', $id)->update(['username' => $name, 'fullname' => $fullname, 'password' => $password]);
        return redirect()->to('danh-sach');
    }

    // Xóa người dùng
    public function delete($id)
    {
        UserModel::where('id', $id)->delete();
        return redirect()->to('danh-sach');
    }

    // Hiển thị form thêm người dùng
    public function add()
    {
        return view('add_user');
    }
    // public function showAllList(){
    //     $products = ProductModel::all(); // Lấy tất cả sản phẩm
    //     return view('show_list', ['products' => $products]); // Trả về view all_products.blade.php với danh sách sản phẩm
    // }
    // Thêm người dùng mới

    public function showRegisterForm()
    {
        return view('register'); // Giả sử bạn đã tạo view 'register.blade.php'
    }
    public function save(Request $request)
    {
        // Xác thực dữ liệu người dùng nhập vào
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',
                'regex:/[A-Z]/',            
                'regex:/[a-z]/',            
                'regex:/[0-9]/',           
                'regex:/[^a-zA-Z0-9]/',    
                function ($attribute, $value, $fail) use ($request) {
                    if (stripos($value, $request->username) !== false) {
                        $fail('Mật khẩu không được chứa username.');
                    }
                },
            ],
        ], [
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.regex' => 'Mật khẩu phải có chữ hoa, chữ thường, số và ký tự đặc biệt.',
        ]);

        $fullname = $request->input('fullname');
        $username = $request->input('username');
        $password = $request->input('password');
        $hashedPassword = Hash::make($password);
        $user = UserModel::where('username', $username)->first();
        if($user){
            return redirect()->back()->with('error', 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.')->withInput();
        }
        UserModel::create([
            'username' => $username,
            'fullname' => $fullname,
            'password' => $hashedPassword
        ]);


        return redirect()->route('user.logins')->with('success', 'Đăng ký thành công!');
    }



    public function logout(Request $request)
    {
        $request->session()->forget('cart');
        // Xóa thông tin người dùng khỏi session
        $request->session()->forget('username');
        $request->session()->forget('user_id');
        $request->session()->forget('fullname');
        $request->session()->forget('is_admin');
        // Chuyển hướng về trang đăng nhập hoặc trang chủ
        return redirect('/')->with('success', 'Đăng xuất tài khoản thành công');
    }
    // Phương thức đăng nhập
    // public function login(Request $request)
    // {
    //     // Lấy thông tin đăng nhập từ form
    //     $username = $request->input('username');
    //     $password = $request->input('password');

    //     // Kiểm tra thông tin đăng nhập
    //     $user = UserModel::where('username', $username)->first();

    //     if ($user && Hash::check($password, $user->password)) {
    //         // Lưu thông tin người dùng vào session
    //         $request->session()->put('username', $username);
    //         $request->session()->put('user_id', $user->id);
    //         $request->session()->put('fullname', $user->fullname);

    //         // Kiểm tra xem user có phải là admin không
    //         if (str_contains($username, 'admin')) {
    //             $request->session()->put('is_admin', true);
    //         } else {
    //             $request->session()->put('is_admin', false);
    //         }

    //         // Chuyển hướng đến trang /showlist hoặc trang home
    //         return redirect('/');
    //     } else {
    //         // Quay lại trang đăng nhập với thông báo lỗi
    //         return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    //     }
    // }
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $user = UserModel::where('username', $login)->first();
        if (!$user && filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $profile = Profile::where('email', $login)->first();
            if ($profile) {
                $user = UserModel::find($profile->user_id);
            }
        }
        if ($user && Hash::check($password, $user->password)) {
            $request->session()->put('user_id', $user->id);
            $request->session()->put('username', $user->username);
            $request->session()->put('fullname', $user->fullname);
            $request->session()->put(
                'is_admin',
                str_contains($user->username, 'admin')
            );

            return redirect('/');
        }

        return back()->with('error', 'Username / Email hoặc mật khẩu không đúng.');
    }


    // Hiển thị trang đăng nhập
    public function logins()
    {
        return view('Login');
    }

    // Hiển thị danh sách sinh viên (hoặc người dùng)
    public function list()
    {
        return view('stud_view');
    }

    // Hiển thị danh sách người dùng từ cơ sở dữ liệu
    public function userLogin()
    {
        $users = DB::select('select * from user');
        return view('stud_view', ['users' => $users]);
    }

    // Cập nhật mật khẩu cho tất cả người dùng trong cơ sở dữ liệu (Bcrypt)
    public function updateAllPasswords()
    {
        // Cập nhật mật khẩu cho tất cả người dùng
        UserModel::all()->each(function ($user) {
            $user->password = Hash::make('new-password');  // Thay thế 'new-password' bằng mật khẩu bạn muốn
            $user->save();
        });

        return redirect()->back()->with('success', 'Mật khẩu của tất cả người dùng đã được cập nhật.');
    }
    public function forgot()
    {
        return view('front.forgot');
    }
}
