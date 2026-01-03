<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\OrderModel as Order;
use App\Models\OrderDetailModel as OrderItem;
use App\Models\ProductModel as Product;
use App\Models\PaymentMethod;
use App\Models\PaymentGateway;
use App\Models\PaymentGatewayHistory;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public $paymentGateway;
    protected $client;
    protected $momo_client;
    //momo
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
        //momo
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
    public function createPMGatewayMomo(Order $order)
    {
        $uuid = Str::random(6);
        $orderId = $order->order_id . '-' . $uuid;

        $redirectUrl = $this->momo_redirect;
        $amountOrder = $order->amount;
        $req_data = [
            'partnerCode' => $this->momo_partner_code,
            'partnerName' => $this->momo_partner_name,
            'storeId' => $order->order_id,
            'requestId' => $uuid,
            'amount' => $amountOrder,
            'orderId' => $orderId,
            'orderInfo' => "test",
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $this->momo_input_url,
            'requestType' => 'captureWallet',
            'extraData' => base64_encode(json_encode($orderId)),
            'lang' => $this->momo_lang,
        ];

        $req_data['signature'] = $this->_hashData(
            'accessKey=' . $this->momo_access_key .
                '&amount=' . $req_data['amount'] .
                '&extraData=' . $req_data['extraData'] .
                '&ipnUrl=' . $req_data['ipnUrl'] .
                '&orderId=' . $orderId .
                '&orderInfo=' . $req_data['orderInfo'] .
                '&partnerCode=' . $req_data['partnerCode'] .
                '&redirectUrl=' . $req_data['redirectUrl'] .
                '&requestId=' . $req_data['requestId'] .
                '&requestType=' . $req_data['requestType']
        );

        $pgh = PaymentGatewayHistory::create([
            'event_name' => PaymentGatewayHistory::EVENT_CREATE_TRANSACTION,
            'request_data' => $req_data,
        ]);

        $this->paymentGateway = PaymentGateway::newModelInstance([
            'status' => PaymentGateway::STATUS_PENDING,
            'amount' => $req_data['amount'],
            'description' => $req_data['orderInfo'],
            'payment_method_id' => $order->payment_method_id,
            'transaction_uuid' => $req_data['requestId'],
        ]);
        $this->paymentGateway->paymentable()->associate($order);
        $this->paymentGateway->save();
        $this->paymentGateway->paymentGatewayHistories()->save($pgh);

        $resp = $this->momo_client->post($this->momo_base_url . '/v2/gateway/api/create', [
            RequestOptions::BODY => json_encode($req_data, JSON_UNESCAPED_UNICODE)
        ]);
        $resp_ar = json_decode($resp->getBody(), true);
        $pgh->paymentGateway()->associate($this->paymentGateway);
        $pgh->response_data = $resp_ar;
        $pgh->message = $resp_ar['message'] ?? PaymentGatewayHistory::MSG_CREATE_TRANSACTION_FAILED;
        $pgh->save();

        if (!isset($resp_ar['resultCode']) || $resp_ar['resultCode'] != 0) {
            $this->paymentGateway->status = PaymentGateway::STATUS_CANCELED;
            $this->paymentGateway->paymentable->status = PaymentGateway::STATUS_CANCELED;
            $this->paymentGateway->paymentable->save();
            $this->paymentGateway->paymentable->refresh();
            $pgh->message = PaymentGatewayHistory::MSG_CREATE_TRANSACTION_FAILED;
            $pgh->save();
        } else {
            $pgh->message = PaymentGatewayHistory::MSG_CREATE_TRANSACTION_SUCCESS;
            $pgh->save();
            $extra_data = $this->paymentGateway->extra_data;
            $extra_data['redirectUrl'] = $req_data['redirectUrl'];
            $extra_data['payUrl'] = $resp_ar['payUrl'] ?? null;
            $extra_data['deeplink'] = $resp_ar['deeplink'] ?? null;
            $extra_data['qrCodeUrl'] = $resp_ar['qrCodeUrl'] ?? null;
            $extra_data['deeplinkMiniApp'] = $resp_ar['deeplinkMiniApp'] ?? null;
            $this->paymentGateway->extra_data = $extra_data;
        }
        $this->paymentGateway->save();

        return $resp_ar;
    }

    private function _hashData(string $data): string
    {
        return hash_hmac("sha256", $data, $this->momo_secret_key);
    }
}
