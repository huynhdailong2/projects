<?php  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use DB;

class CategoryController extends Controller
{

    public function list(Request $request){
        $items = CategoryModel::all();
    
        return view('cate_list',['items'=>$items]);

    }

    public function show($id){
        $item = CategoryModel::where('Category_ID',$id)->get();
        return view('cate_info',['item'=>$item]);
    }

    public function update(Request $request){
        $name = $request->input("txt_name");
        $description = $request->input("txt_description");
        $id = $request->input("txt_id");
        CategoryModel::where('Category_ID',$id)->update(['Category_description'=>$description,'Category_name'=>$name]);
        return redirect()->to('admin/danh-sach-danh-muc');
    }

    public function del($id){
        $rs=CategoryModel::where('Category_ID',$id)->delete();
        return redirect()->to('admin/danh-sach-danh-muc');
    }


    public function add(){
        return view('cate_add');
    }
    // Thêm người dùng
    public function save(Request $request){
        $name = $request->input("txt_name");
        $description = $request->input("txt_description");
   
        CategoryModel::insert(['Category_name'=>$name,'Category_description'=>$description]);
        return redirect()->to('admin/danh-sach-danh-muc');
    }

}
?>