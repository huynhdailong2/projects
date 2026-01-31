<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use App\Models\PaymentGatewayHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class PaymentGatewayController extends Controller
{
    public function list(): View
    {
        $payments = PaymentGateway::with([
            'paymentMethod',
            'paymentable',
            'order',
            'paymentGatewayHistories',
        ])->paginate(10);

        return view('admin.payments.list', compact('payments'));
    }
    public function paymentRequest($id): Response
    {
        $histories = PaymentGatewayHistory::where('payment_gateway_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id'            => $item->id,
                    'event_name'    => $item->event_name,
                    'message'       => $item->message,
                    'request_data'  => $item->request_data,
                    'response_data' => $item->response_data,
                    'created_at'    => $item->created_at?->toDateTimeString(),
                ];
            });

        return response()->json($histories);
    }
}
