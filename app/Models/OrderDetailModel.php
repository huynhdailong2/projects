<?php 
    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class OrderDetailModel extends Model
    {
        public function product()
        {
            return $this->belongsTo(ProductModel::class, 'Product_ID', 'Product_ID');  // Đảm bảo 'Product_ID' là khóa ngoại chính xác
        }
        
        protected $table = 'order_detail';
        public $timestamps = false;  // Nếu có trường created_at và updated_at
        use HasFactory;

        // Khai báo các trường có thể gán giá trị
        protected $fillable = ['order_id', 'Product_ID', 'Quantily', 'Price'];

        // Mối quan hệ với ProductModel (sản phẩm)// Model OrderDetailModel

        // Mối quan hệ với OrderModel (đơn hàng)
        public function order()
        {
            return $this->belongsTo(OrderModel::class, 'order_id');
        }
    }
