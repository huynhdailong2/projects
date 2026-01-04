<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notification;
class PaymentGateway extends Model
{
    use SoftDeletes;

    CONST STATUS_NEW = 'NEW';
    CONST STATUS_PAID = 'PAID';
    CONST STATUS_ERROR = 'ERROR';
    CONST STATUS_PENDING = 'PENDING';
    CONST STATUS_CANCELED = 'CANCELED';
    CONST METHOD_VNPAY = 'VNPAY';
    CONST TRANSACTION_STATUS_SUCCESS = 00;
    CONST TRANSACTION_STATUS_FAILED = 02;
    CONST STATUS_CANCELED_BY_USER = 'CANCELED_BY_USER';

    protected $fillable = [
        'status',
        'amount',
        'amount_paid',
        'description',
        'transaction_uuid',
        'transaction_id',
        'created_at',
        'updated_at',
        'payment_method_id',
        'extra_data',
    ];
    protected $casts = [
        'amount' => 'float',
        'extra_data' => 'array',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
    protected $hidden = [
        'transaction_id',
        'payment_method',
        'paymentable',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function paymentGatewayHistories(): HasMany
    {
        return $this->hasMany(PaymentGatewayHistory::class);
    }

    public function paymentable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }
    public function order(): BelongsTo
    {
        return $this->belongsTo(OrderModel::class, 'paymentable_id');
    }
}
