<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class CategoryModel extends Model
{
    protected $table = 'category';
    public $timestamps = false;
    protected $fillable = ['Category_ID ', 'Category_name', 'Category_description'];
    use HasFactory;
}
