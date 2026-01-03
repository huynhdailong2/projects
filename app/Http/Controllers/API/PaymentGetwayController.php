<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayHistory;
use GuzzleHttp\Client;

class PaymentGetwayController extends Controller
{

    public $paymentGateway;
    protected $client;
    protected $momo_client;
    protected $momo_partner_code;
    protected $momo_secret_key;
    protected $momo_access_key;
    protected $momo_redirect;
    protected $momo_partner_name;
    protected $momo_base_url;
    protected $momo_deep_link;
    protected $momo_lang;
    protected $momo_input_url;

    public function __construct()
    {
        $this->client = new Client();
        // //momo
        $this->momo_partner_code = "MOMOAR3G20211022";
        $this->momo_secret_key = "KjeXxvqdKpUnfwwBannqYkqILsjdcJpj";
        $this->momo_access_key = "z6TZJeskXV5DHal9";
        $this->momo_redirect = "https://doan.dyca.vn/api/paymentGetwayDataMomo";
        $this->momo_partner_name = "Myspa Dev";
        $this->momo_base_url = "https://test-payment.momo.vn";
        $this->momo_deep_link = "momo://?refId=dev_tool&tripId=GKX2SYA&tranxId=mipay_4179&appId=miniapp.TrkMv54nrF1g1UmRGp1i.myspaapp&deeplink=true&url=";
        $this->momo_lang = \Config::get('app.locale', 'vi');
        $this->momo_input_url = 'https://doan.dyca.vn/api/paymentGetwayDataMomo';
        $this->momo_client = new Client([
            'headers' => ['Content-Type' => 'application/json; charset=UTF-8'],
            'http_errors' => false,
            'verify' => false,
        ]);
    }
    public function paymentGetwayData(Request $request)
    {
        $paymentGateway = PaymentGateway::where('transaction_uuid', $request->vnp_TxnRef)->first();
        if (isset($request->vnp_TransactionStatus)) {
            $paymentGateway->paymentable->refresh();
            if ($request->vnp_TransactionStatus == PaymentGateway::TRANSACTION_STATUS_SUCCESS) {
                if ($paymentGateway->paymentable->status != PaymentGateway::STATUS_PAID) {
                    $paymentGateway->transaction_id = $request->vnp_TransactionNo;
                    $paymentGateway->status = PaymentGateway::STATUS_PAID;
                    $paymentGateway->save();
                    $paymentGateway->paymentable->status = PaymentGateway::STATUS_PAID;
                    $paymentGateway->paymentable->save();
                    $paymentGateway->paymentGatewayHistories()->create([
                        "event_name" => PaymentGateway::STATUS_PAID,
                        "message" => PaymentGatewayHistory::MSG_CREATE_TRANSACTION_SUCCESS,
                        "response_data" => $request->all()
                    ]);
                    $this->addCommission($paymentGateway->order);
                }
            } else if ($request->vnp_TransactionStatus == PaymentGateway::TRANSACTION_STATUS_FAILED) {
                if ($paymentGateway->paymentable->status != PaymentGateway::STATUS_CANCELED_BY_USER) {
                    $paymentGateway->transaction_id = $request->vnp_TransactionNo;
                    $paymentGateway->status = PaymentGateway::STATUS_CANCELED_BY_USER;
                    $paymentGateway->save();
                    $paymentGateway->paymentable->status = PaymentGateway::STATUS_CANCELED_BY_USER;
                    $paymentGateway->paymentable->save();
                    $paymentGateway->paymentGatewayHistories()->create([
                        "event_name" => PaymentGateway::STATUS_CANCELED_BY_USER,
                        "message" => PaymentGatewayHistory::MSG_CANCELED,
                        "response_data" => $request->all()
                    ]);
                }
            } else {
                if ($paymentGateway->paymentable->status != PaymentGateway::STATUS_CANCELED) {
                    $paymentGateway->transaction_id = $request->vnp_TransactionNo;
                    $paymentGateway->status = PaymentGateway::STATUS_CANCELED;
                    $paymentGateway->save();
                    $paymentGateway->paymentable->status = PaymentGateway::STATUS_CANCELED;
                    $paymentGateway->paymentable->save();
                    $paymentGateway->paymentGatewayHistories()->create([
                        "event_name" => PaymentGateway::STATUS_CANCELED,
                        "message" => PaymentGatewayHistory::MSG_CANCELED,
                        "response_data" => $request->all()
                    ]);
                }
            }
        }
        return redirect()->away('https://doan.dyca.vn/hoa-don/' . $paymentGateway->order->order_id);
    }
    public function status($transactionUuid): JsonResponse
    {
        if (is_numeric($transactionUuid)) {
            $pg = PaymentGateway::with('paymentGatewayHistories')->findOrFail($transactionUuid);
        } else {
            $pg = PaymentGateway::with('paymentGatewayHistories')->where(['transaction_uuid' => $transactionUuid])->firstOrFail();
        }
        $pg->refresh();
        return $this->jsonResponse($pg->toArray());
    }
    public function paymentGetwayDataMomo(Request $request)
    {
        $pgh = PaymentGatewayHistory::create([
            'event_name' => PaymentGatewayHistory::EVENT_IPN_MOMO,
            'request_data' => $request->all(),
        ]);

        $hashCheck = $this->_hashData(
            'accessKey=' . $this->momo_access_key .
                '&amount=' . $request->get('amount') .
                '&extraData=' . $request->get('extraData') .
                '&message=' . $request->get('message') .
                '&orderId=' . $request->get('orderId') .
                '&orderInfo=' . $request->get('orderInfo') .
                '&orderType=' . $request->get('orderType') .
                '&partnerCode=' . $request->get('partnerCode') .
                '&payType=' . $request->get('payType') .
                '&requestId=' . $request->get('requestId') .
                '&responseTime=' . $request->get('responseTime') .
                '&resultCode=' . $request->get('resultCode') .
                '&transId=' . $request->get('transId')
        );

        $pg = PaymentGateway::where(['transaction_uuid' => $request->get('requestId')])->firstOrFail();
        if (!$pg) {
            $pgh->message = PaymentGatewayHistory::MSG_PAYMENT_GATEWAY_NOT_FOUND;
            $pgh->save();
            throw new \Exception(PaymentGatewayHistory::MSG_PAYMENT_GATEWAY_NOT_FOUND, 500);
        } else {
            $pg->paymentGatewayHistories()->save($pgh);
        }

        if ($hashCheck != $request->get('signature')) {
            $pgh->message = PaymentGatewayHistory::MSG_CALLBACK_INVALID;
            $pgh->save();
            throw new \Exception(PaymentGatewayHistory::MSG_CALLBACK_INVALID, 500);
        }

        $resultCode = $request->get('resultCode');
        $resp_data = [
            'partnerCode' => $this->momo_partner_code,
            'requestId' => $pg->transaction_uuid,
            'orderId' => $request->get('orderId'),
            'resultCode' => 0,
            'message' => PaymentGateway::STATUS_PAID,
            'responseTime' => time(),
            'extraData' => $request->get('extraData'),
        ];
        $resp_data['signature'] = $this->_hashData(
            'accessKey=' . $this->momo_access_key .
                '&extraData=' . $resp_data['extraData'] .
                '&message=' . $resp_data['message'] .
                '&orderId=' . $resp_data['orderId'] .
                '&partnerCode=' . $resp_data['partnerCode'] .
                '&requestId=' . $resp_data['requestId'] .
                '&responseTime=' . $resp_data['responseTime'] .
                '&resultCode=' . $resp_data['resultCode']
        );
        $pgh->message = $request->get('message');
        $pgh->response_data = $resp_data;
        $pgh->save();
        if ($resultCode != 0) {
            $pg->status = PaymentGateway::STATUS_CANCELED_BY_USER;
            $pg->amount = $request->get('amount', 0);
            $pg->transaction_id = $request->get('transId');
            $pg->save();
            $pg->paymentable->status = PaymentGateway::STATUS_CANCELED_BY_USER;
            $pg->paymentable->save();
            $pg->order->status = PaymentGateway::STATUS_CANCELED_BY_USER;
            $pg->order->save();
        } else if ($resultCode == 0) {
            $pg->status = PaymentGateway::STATUS_PAID;
            $pg->amount = $request->get('amount', 0);
            $pg->transaction_id = $request->get('transId');
            $pg->save();
            $pg->paymentable->status = PaymentGateway::STATUS_PAID;
            $pg->paymentable->save();
            $pg->order->status = PaymentGateway::STATUS_PAID;
            $pg->order->save();
        }
        return redirect()->away('https://doan.dyca.vn/user/order/detail/' . $pg->order->order_id);
    }
    private function _hashData(string $data): string
    {
        return hash_hmac("sha256", $data, $this->momo_secret_key);
    }
}
