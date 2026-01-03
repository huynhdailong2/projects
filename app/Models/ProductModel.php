<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'product'; // Chỉ định tên bảng
    public $timestamps = false; // Nếu bảng không sử dụng cột timestamps
    protected $primaryKey = 'Product_ID'; // Đảm bảo cột khóa chính là Product_ID
    public function orderDetails()
    {
        return $this->hasMany(OrderDetailModel::class, 'Product_ID');
    }
    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'cate_id', 'Category_ID');
    }
    

    use HasFactory;
}
