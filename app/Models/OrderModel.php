<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table = 'order';  // Đảm bảo tên bảng đúng
    public $timestamps = true;
    protected $primaryKey = 'order_id';  // Cập nhật tên cột khóa chính của bạn
    protected $keyType = 'int';  // Kiểu khóa chính là int nếu là số nguyên
    protected $fillable = [
        'user_id', 
        'order_user', 
        'created_at', 
        'payment', // Thêm trường payment vào đây
        'shipping', 
        'status', 
        'note', // Thêm trường note vào đây
        'address',
        'transport',
        'updated_at'
    ];

    use HasFactory;
    public function details() {
        return $this->hasMany(OrderDetailModel::class, 'order_id', 'order_id');
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetailModel::class, 'order_id');  // Quan hệ với order_details
    }
}
