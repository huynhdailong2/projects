<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ProductModel;

use App\Models\CategoryModel;
use DB;

class ProductController extends Controller
{
   

    public function search(Request $request)
    {
        // Lấy từ khóa tìm kiếm từ người dùng
        $keyword = $request->input('keyword');

        // Tìm kiếm sản phẩm dựa trên từ khóa
        $products = ProductModel::where('Name', 'like', '%' . $keyword . '%')
            ->orWhere('Description', 'like', '%' . $keyword . '%')
            ->get();

        // Trả về view với danh sách sản phẩm tìm kiếm được
        return view('product_show', compact('products', 'keyword'));
    }

    public function filterByCategory($category)
    {
        $category = urldecode($category); // Giải mã tên category nếu cần thiết
        $products = ProductModel::whereHas('category', function ($query) use ($category) {
            $query->where('Category_name', $category);
        })->get();

        return view('product_show', compact('products', 'category'));
    }

    public function ShowDetail($id)
    {
        $items = ProductModel::where('Product_ID', $id)->get();
        $categories = CategoryModel::all();
        return view('product_detail', ['items' => $items, 'categories' => $categories]);
    }

    public function showAllProducts()
    {
        $products = ProductModel::all(); // Lấy tất cả sản phẩm
        return view('product_show', ['products' => $products]); // Trả về view all_products.blade.php với danh sách sản phẩm
    }
    public function showAllList()
    {
        $products = ProductModel::all(); // Lấy tất cả sản phẩm
        return view('show_list', ['products' => $products]); // Trả về view all_products.blade.php với danh sách sản phẩm
    }
    public function list(Request $request)
    {
        $items = ProductModel::join('category', 'category.Category_ID', '=', 'product.cate_id')->get();
        // $categories=CategoryModel::all();   
        return view('product_list', ['items' => $items]);

    }

    public function show($id)
    {
        $item = ProductModel::where('Product_ID', $id)->get();
        $categories = CategoryModel::all();
        return view('product_info', ['item' => $item, 'categories' => $categories]);
    }

    public function update(Request $request)
    {
        $name = $request->input("txt_name");
        $description = $request->input("txt_description");
        $id = $request->input("txt_id");
        $category = $request->input("txt_category");
        $price = $request->input("txt_price");
        $quantily = $request->input("txt_quantily");
        if (!$request->hasFile('txt_image')) {
            $img = $request->input('txt_img_old');

        } else {
            $image = $request->file('txt_image');
            $storedPath = $image->move('image', $image->getClientOriginalName());
            $img = '/images/' . $image->getClientOriginalName();
        }
        ProductModel::where('Product_ID', $id)->update(['Description' => $description, 'Name' => $name, 'Img' => $img, 'cate_id' => $category, 'Quantily' => $quantily, 'Price' => $price]);
        return redirect()->to('danh-sach-san-pham');
    }

    public function del($id)
    {
        $rs = ProductModel::where('Product_ID', $id)->delete();
        return redirect()->to('/danh-sach-san-pham');
    }


    public function add()
    {
        $categories = CategoryModel::all();
        return view('product_add', ['categories' => $categories]);
    }
    // Thêm người dùng
    public function save(Request $request)
    {
        $name = $request->input("txt_name");
        $description = $request->input("txt_description");
        $category = $request->input('txt_category');
        $price = $request->input("txt_price");
        $quantily = $request->input('txt_quantily');
        // $img= $request->file('txt_image');
        // $imagename= time().'.'.$img->getClientOriginalExtension();
        // $img->move (public_path('images'),$imagename);


        if (!$request->hasFile('txt_image')) {
            // Nếu không thì in ra thông báo
            return "Mời chọn file cần upload";
        } else {
            $image = $request->file('txt_image');
            $storedPath = $image->move('images', $image->getClientOriginalName());
            $img = '/images/' . $image->getClientOriginalName();
        }
        // Nếu có thì thục hiện lưu trữ file vào public/images


        ProductModel::insert(['Name' => $name, 'Description' => $description, 'cate_id' => $category, 'img' => $img, 'Price' => $price, 'Quantily' => $quantily]);


        // CategoryModel::insert(['Category_name'=>$name,'Category_description'=>$description]);
        return redirect()->to('/danh-sach-san-pham');

    }
}
?>