<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class OrderMail extends Mailable
{
    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this
            ->subject('Đặt hàng thành công')
            ->from(
                config('mail.from.address'),
                config('mail.from.name')
            )
            ->view('mail.order');
    }
}
