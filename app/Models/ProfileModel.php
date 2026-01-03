<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileModel extends Model
{
    use HasFactory;

    protected $table = 'profile';
    public $timestamps = false;
    protected $primaryKey = 'id_profile';
    protected $attributes = [
        'image' => null, // Giá trị mặc định cho trường image
    ];
    protected $fillable = [
        'user_id', 'address', 'email', 'birthday', 'image', 'name','phone'
    ];
 
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

}
