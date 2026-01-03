<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class UserModel extends Model
{
    
    protected $table = 'users';
    protected $fillable = ['username', 'password', 'fullname'];
    public $timestamps = false;
    use HasFactory;
    public function profile()
    {
        return $this->hasOne(ProfileModel::class, 'user_id', 'id');
    }

}

