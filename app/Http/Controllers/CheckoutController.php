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
    protected $paypal_client;
    protected $paypal_base_url;
    protected $paypal_client_id;
    protected $paypal_secret;

    public function __construct()
    {
        $this->client = new Client();
        //momo
        $this->momo_partner_code = \Config::get('services.momo.partner_code');
        $this->momo_secret_key = \Config::get('services.momo.secret_key');
        $this->momo_access_key = \Config::get('services.momo.access_key');
        $this->momo_redirect = \Config::get('services.momo.redirect');
        $this->momo_partner_name = \Config::get('services.momo.partner_name');
        $this->momo_base_url = \Config::get('services.momo.base_url_v2');
        $this->momo_deep_link = \Config::get('services.momo.deeplink');
        $this->momo_input_url = 'https://doan.dyca.vn/api/paymentGetwayDataMomo';
        $this->momo_client = new Client([
            'headers' => ['Content-Type' => 'application/json; charset=UTF-8'],
            'http_errors' => false,
            'verify' => false,
        ]);
        $this->paypal_client_id = config('services.paypal.client_id');
        $this->paypal_secret = config('services.paypal.secret');
        $this->paypal_base_url = config('services.paypal.base_url');

        $this->paypal_client = new Client([
            'auth' => [$this->paypal_client_id, $this->paypal_secret],
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'http_errors' => false,
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
    private function getPaypalAccessToken()
    {
        $resp = $this->paypal_client->post(
            $this->paypal_base_url . '/v1/oauth2/token',
            [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]
        );

        $data = json_decode($resp->getBody(), true);
        return $data['access_token'] ?? null;
    }
    public function createPMGatewayPaypal(Order $order)
    {
        $accessToken = $this->getPaypalAccessToken();
        if (!$accessToken) {
            throw new \Exception('Không lấy được PayPal access token');
        }

        $reqData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => $order->order_id,
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => number_format($order->amount, 2, '.', ''),
                    ],
                ],
            ],
            'application_context' => [
                'return_url' => config('services.paypal.redirect'),
                'cancel_url' => config('services.paypal.cancel'),
            ],
        ];

        $pgh = PaymentGatewayHistory::create([
            'event_name' => PaymentGatewayHistory::EVENT_CREATE_TRANSACTION,
            'request_data' => $reqData,
        ]);

        // ✅ KHỞI TẠO BẰNG newModelInstance (KHÔNG create)
        $this->paymentGateway = new PaymentGateway([
            'status' => PaymentGateway::STATUS_PENDING,
            'amount' => $order->amount,
            'description' => 'PayPal payment',
            'payment_method_id' => $order->payment_method_id,
        ]);

        // ✅ ASSOCIATE TRƯỚC
        $this->paymentGateway->paymentable()->associate($order);
        $this->paymentGateway->save();

        $this->paymentGateway->paymentGatewayHistories()->save($pgh);

        // Gọi PayPal
        $resp = $this->paypal_client->post(
            $this->paypal_base_url . '/v2/checkout/orders',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                RequestOptions::JSON => $reqData,
            ]
        );

        $respData = json_decode($resp->getBody(), true);

        $pgh->response_data = $respData;
        $pgh->message = $respData['status'] ?? 'PAYPAL_CREATE_FAILED';
        $pgh->save();

        if (!isset($respData['status']) || $respData['status'] !== 'CREATED') {
            $this->paymentGateway->status = PaymentGateway::STATUS_CANCELED;
            $this->paymentGateway->paymentable->status = PaymentGateway::STATUS_CANCELED;
            $this->paymentGateway->paymentable->save();
            $this->paymentGateway->save();
            return $respData;
        }

        // ✅ PAYPAL ORDER ID = transaction_uuid
        $this->paymentGateway->transaction_uuid = $respData['id'];

        foreach ($respData['links'] as $link) {
            if ($link['rel'] === 'approve') {
                $extra = $this->paymentGateway->extra_data ?? [];
                $extra['approve_url'] = $link['href'];
                $this->paymentGateway->extra_data = $extra;
                break;
            }
        }

        $this->paymentGateway->save();

        return $respData;
    }


    public function paypalSuccess(Request $request)
    {
        $paypalOrderId = $request->get('token');
        if (!$paypalOrderId) {
            abort(400, 'Missing PayPal token');
        }

        // ✅ LẤY ĐÚNG PAYMENT GATEWAY
        $pg = PaymentGateway::where('transaction_uuid', $paypalOrderId)->firstOrFail();

        $pgh = PaymentGatewayHistory::create([
            'event_name' => PaymentGatewayHistory::MSG_EVENT_CALLBACK_PAYPAL,
            'request_data' => $request->all(),
        ]);
        $pg->paymentGatewayHistories()->save($pgh);

        $accessToken = $this->getPaypalAccessToken();
        if (!$accessToken) {
            $pgh->message = 'PAYPAL_ACCESS_TOKEN_FAILED';
            $pgh->save();
            abort(500);
        }

        // 🔥 CAPTURE
        $resp = $this->paypal_client->post(
            $this->paypal_base_url . "/v2/checkout/orders/{$paypalOrderId}/capture",
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
            ]
        );

        $respData = json_decode($resp->getBody(), true);

        $pgh->response_data = $respData;
        $pgh->save();

        // ❌ Capture fail
        if (!isset($respData['status']) || $respData['status'] !== 'COMPLETED') {
            $pg->status = PaymentGateway::STATUS_CANCELED;
            $pg->save();

            $pg->paymentable->status = PaymentGateway::STATUS_CANCELED;
            $pg->paymentable->save();

            $pg->order->status = PaymentGateway::STATUS_CANCELED;
            $pg->order->save();

            $pgh->message = 'PAYPAL_CAPTURE_FAILED';
            $pgh->save();

            return redirect()->away(
                'https://doan.dyca.vn/hoa-don/' . $pg->order->user_id
            );
        }

        // ✅ Capture OK
        $capture = $respData['purchase_units'][0]['payments']['captures'][0] ?? null;

        $pg->status = PaymentGateway::STATUS_PAID;
        $pg->transaction_id = $capture['id'] ?? null;
        $pg->amount = $capture['amount']['value'] ?? $pg->amount;
        $pg->save();

        $pg->paymentable->status = PaymentGateway::STATUS_PAID;
        $pg->paymentable->save();

        $pg->order->status = PaymentGateway::STATUS_PAID;
        $pg->order->save();

        $pgh->message = PaymentGatewayHistory::MSG_CREATE_TRANSACTION_SUCCESS;
        $pgh->save();

        return redirect()->away(
            'https://doan.dyca.vn/hoa-don/' . $pg->order->user_id
        );
    }

    public function paypalCancel(Request $request)
    {
        $paypalOrderId = $request->get('token');

        if (!$paypalOrderId) {
            abort(400, 'Missing PayPal token');
        }

        $pg = PaymentGateway::where('transaction_uuid', $paypalOrderId)->firstOrFail();

        $pgh = PaymentGatewayHistory::create([
            'event_name' => PaymentGatewayHistory::MSG_EVENT_CANCEL_PAYPAL,
            'request_data' => $request->all(),
            'message' => PaymentGatewayHistory::MSG_CANCELED,
        ]);
        $pg->paymentGatewayHistories()->save($pgh);

        if ($pg->status !== PaymentGateway::STATUS_PAID) {

            $pg->status = PaymentGateway::STATUS_CANCELED;
            $pg->save();

            $pg->paymentable->status = PaymentGateway::STATUS_CANCELED;
            $pg->paymentable->save();

            $pg->order->status = PaymentGateway::STATUS_CANCELED;
            $pg->order->save();
        }

        return redirect()->away(
            'https://doan.dyca.vn/hoa-don/' . $pg->order->user_id
        );
    }


}
