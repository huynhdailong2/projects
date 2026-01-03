<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function showdb(){

        return view('dashboard'); // Trả về view all_products.blade.php với danh sách sản phẩm
    }
    
}
