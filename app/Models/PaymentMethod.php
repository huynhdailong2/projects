<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentMethod extends Model
{
    use SoftDeletes, HasFactory;
    const METHOD_MOMO = 1;
    const METHOD_COD = 2;
    const METHOD_MOMO_NAME = "MOMO";
    const METHOD_COD_NAME = "COD";
    public $table = 'payment_methods';
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];
    public $fillable = [
        'name_key'
    ];
}
