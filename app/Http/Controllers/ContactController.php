<?php

namespace App\Http\Controllers;

use App\Models\ContactModel;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Hiển thị form liên hệ
    public function show()
    {
        return view('contact');
    }

    // Lưu dữ liệu vào cơ sở dữ liệu
    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'note' => 'nullable|string',
        ]);
    
        ContactModel::create($request->only(['name', 'email', 'note']));
    
        // Chuyển hướng lại trang contact với thông báo
        return redirect()->route('contact.show')->with('success', 'Gửi liên hệ thành công!');
    }
    

    // Hiển thị danh sách liên hệ
    public function index()
    {
        $contacts = ContactModel::all();

        return view('contact_list', compact('contacts'));
    }
}
