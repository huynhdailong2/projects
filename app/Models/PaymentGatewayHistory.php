<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentGatewayHistory extends Model
{

    CONST EVENT_CREATE_TRANSACTION = 'CREATE';
    CONST EVENT_IPN_MOMO = 'IPN_VNPAY';
    CONST EVENT_STATUS = 'STATUS';
    CONST EVENT_CONFIRM = 'CONFIRM';
    CONST EVENT_REFUND = 'REFUND';
    CONST EVENT_REFUND_STATUS = 'REFUND_STATUS';
    CONST EVENT_CANCEL = 'CANCEL';

    CONST MSG_CREATE_TRANSACTION_FAILED = 'CREATE_TRANSACTION_FAILED';
    CONST MSG_CREATE_TRANSACTION_SUCCESS = 'MSG_CREATE_TRANSACTION_SUCCESS';
    CONST MSG_PAYMENT_GATEWAY_NOT_FOUND = 'PAYMENT_GATEWAY_NOT_FOUND';
    CONST MSG_PAYMENT_GATEWAY_TRANSACTION_NOT_FOUND = 'PAYMENT_GATEWAY_TRANSACTION_NOT_FOUND';
    CONST MSG_PAYMENT_GATEWAY_FOUND = 'PAYMENT_GATEWAY_FOUND';
    CONST MSG_CALLBACK_INVALID = 'CALLBACK_INVALID';
    CONST MSG_IPN_INVALID = 'IPN_INVALID';
    CONST MSG_HASH_INVALID = 'HASH_INVALID';
    CONST MSG_ALREADY_PAID = 'ALREADY_PAID';
    CONST MSG_CANCELED = 'CANCELED';
    CONST MSG_CANCELED_AMOUNT_NOT_MATCH = 'CANCELED_AMOUNT_NOT_MATCH';

    protected $fillable = [
        'event_name',
        'request_data',
        'response_data',
        'created_at',
        'updated_at',
        'message',
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'request_data' => 'json',
        'response_data' => 'json',
    ];
    protected $hidden = [
        'request_data',
        'response_data',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function paymentGateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }
}
