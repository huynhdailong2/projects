<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileModel;
use App\Models\UserModel;

class ProfileController extends Controller
{


    public function edit($id)
    {
        // Lấy thông tin hồ sơ từ ProfileModel liên kết với UserModel
        $item = ProfileModel::join('users', 'users.id', '=', 'profile.user_id')
            ->where('profile.user_id', $id) // Lọc theo ID
            ->first(); // Lấy bản ghi đầu tiên

        // Nếu không tìm thấy hồ sơ, trả về lỗi 404
        if (!$item) {
            return redirect()->route('profile-user')->with('error', 'Profile not found');
        }

        // Trả về view chỉnh sửa với thông tin hồ sơ
        return view('profile_edit', compact('item'));
    }



    public function update(Request $request)
    {
        // Validate đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|max:15',
            'birthday' => 'required|date',
            'image' => 'nullable|image|max:2048'
        ]);

        // Lấy user_id từ session và tìm profile
        $userId = session('user_id');
        $profile = ProfileModel::where('user_id', $userId)->first();

        // Kiểm tra xem profile có tồn tại không
        if (!$profile) {
            return redirect()->route('profile.user')->with('error', 'Profile not found');
        }

        // Cập nhật các trường
        $profile->name = $request->name;
        $profile->address = $request->address;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->birthday = $request->birthday;

        // Xử lý upload hình ảnh nếu có
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images'), $imageName);
        
            // Lưu đường dẫn ảnh vào cơ sở dữ liệu
            $profile->image = 'assets/images/' . $imageName;
        }
        

        // Lưu các thay đổi
        $profile->save();

        // Chuyển hướng và thông báo thành công
        return redirect()->to('profile-user')->with('success', 'Profile updated successfully.');
    }

    public function show()
    {
        $userId = session('user_id'); // Lấy user_id từ session



        // Tìm bản ghi profile của người dùng dựa vào user_id
        $item = ProfileModel::where('user_id', $userId)->first();

        //Nếu không tìm thấy bản ghi profile với user_id tương ứng, có thể trả về lỗi 404
        if (!$item) {
            return view('profile', compact('item'));
        }

        // Nếu tìm thấy profile, trả về view profile với thông tin của profile
        return view('profile_user', compact('item'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:profile',
            'phone' => 'required|string|max:15',
            'birthday' => 'required|date',
            'image' => 'nullable|image|max:2048'
        ]);

        $users = session('user_id');

        if (!$request->hasFile('image')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        } else {
            $image = $request->file('image');
            $storedPath = $image->move('assets/images', $image->getClientOriginalName());
            $img = 'assets/images/' . $image->getClientOriginalName();
        }
        $profile = new ProfileModel();
        $profile->user_id = $users;
        $profile->name = $request->name;
        $profile->address = $request->address;
        $profile->email = $request->email;
        $profile->phone = $request->phone;
        $profile->birthday = $request->birthday;
        $profile->image = $img;
        $profile->save();
        // $request->session()->put('user_id', $users);
        return redirect()->to('profile-user')->with('success', 'Profile created successfully.');
    }
}
