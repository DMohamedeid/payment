<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class PaymobController extends Controller
{

//    public function authenticationRequest(Request $request)
//    {
//
//        // this only to get the information of the user account
//
//        $api_key = [
//            'api_key' => 'ZXlKaGJHY2lPaUpJVXpVeE1pSXNJblI1Y0NJNklrcFhWQ0o5LmV5SmpiR0Z6Y3lJNklrMWxjbU5vWVc1MElpd2libUZ0WlNJNkltbHVhWFJwWVd3aUxDSndjbTltYVd4bFgzQnJJam8xTWpnNU16UjkuNGp6YXd4OEFpZVpXclZiZWk4NGNOdjlDTl9STTIzV3BCeEIzRGZ0OTFWXzZ4cWs3QUxOa3ZEYjNkTTV2ZGlyeGQ0d0hUdTBpTTBSVmRzYnFLNDh2SVE='
//        ];
//
//        $data = Http::post('https://accept.paymob.com/api/auth/tokens', $api_key);
//
//        $order_id =  rand(0, 999);
//
//        if (array_key_exists('incorrect credentials', $data->json())) {
//            return response()->json([
//                'error' => 'You are not authenticated',
//            ], 401);
//        } else {
//            //this to create the Order Registration API
//            $token = $data->object()->token;
//
//            $retrieve_data = [
//                "auth_token" => $token,
//                "delivery_needed" => "false",
//                "amount_cents" => 100 * 100,
//                "currency" => "EGP",
//                "merchant_order_id" => $order_id,
//                "items" => [],
//            ];
//
//            $orderRegistrationAPI = Http::post('https://accept.paymob.com/api/ecommerce/orders', $retrieve_data);
//
//            if (array_key_exists('duplicate', $orderRegistrationAPI->json())) {
//                return response()->json([
//                    'message' => 'Your Order is duplicated',
//                ], 401);
//            } else {
//                $payment_order_id = $orderRegistrationAPI->object()->id;
//
//                $payment_key_request = [
//                    "auth_token" => $token,
//                    "amount_cents" => 100 * 100,
//                    "expiration" => 36000,
//                    "order_id" => $payment_order_id,
//                    "billing_data" => [
//                        "first_name" => "test",
//                        "last_name" => "test",
//                        "email" => "test@test.com",
//                        "phone_number" => "01234567899",
//                        "apartment" => "NA",
//                        "floor" => "NA",
//                        "street" => "NA",
//                        "building" => "NA",
//                        "shipping_method" => "NA",
//                        "postal_code" => "NA",
//                        "city" => "NA",
//                        "country" => "NA",
//                        "state" => "NA",
//                    ],
//                    "currency" => "EGP",
//                    "integration_id" => 2835506,
////                    "integration_id" => 2839817
//                ];
//                $paymentKeyRequest = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', $payment_key_request);
//                if (array_key_exists("token", $paymentKeyRequest->json())) {
//
//                    $payment_token = $paymentKeyRequest->object()->token;
//
//                    $card_iframe_id = 680215;
//
////                    $iframe_id = 680490;
//
////                    $test_card = Http::get('https://accept.paymobsolutions.com/api/acceptance/iframes/' . $card_iframe_id . '?payment_token=' . $payment_token);
//                    $test_card = Http::get('https://accept.paymob.com/api/acceptance/iframes/680215?payment_token=' . $payment_token);
//
////                    $test_mobileWallet = Http::post('https://accept.paymob.com/api/acceptance/payments/pay' . $iframe_id . '?payment_token=' . $payment_token);
//
//                    return Redirect::away('https://accept.paymob.com/api/acceptance/iframes/680215?payment_token=' . $payment_token);
////                    return $test_card;
//                }
//            }
//
//        }
//
//    }

    public function getToken() {
        $response = Http::post('https://accept.paymob.com/api/auth/tokens', [
            'api_key' => env('PAYMOB_API_KEY')
        ]);
        if (array_key_exists('incorrect credentials', $response->json())) {
            return response()->json([
                'error' => 'You are not authenticated',
            ], 401);
        } else {
            return $response->object()->token;
        }
    }

    public function createOrder($token) {
        $items = [
//            [ "name"=> "ASC1515",
//                "amount_cents"=> "500000",
//                "description"=> "Smart Watch",
//                "quantity"=> "1"
//            ],
//            [
//                "name"=> "ERT6565",
//                "amount_cents"=> "200000",
//                "description"=> "Power Bank",
//                "quantity"=> "1"
//            ]
        ];

        $data = [
            "auth_token" =>   $token,
            "delivery_needed" =>"false",
            "merchant_order_id" => rand(0, 999),
            "amount_cents"=> 100 * 100,
            "currency"=> "EGP",
            "items"=> $items,

        ];
        $response = Http::post('https://accept.paymob.com/api/ecommerce/orders', $data);
        if (array_key_exists('duplicate', $response->json())) {
            return response()->json([
                'message' => 'Your Order is duplicated',
            ], 401);
        } else {
            return $response->object();
        }
    }

    public function getPaymentToken($order , $token , $integration_id)
    {

        $billingData = [
            "apartment" => "NA",
            "email" => "test@test.com",
            "floor" => "NA",
            "first_name" => "test",
            "street" => "NA",
            "building" => "NA",
            "phone_number" => "+86(8)9135210487",
            "shipping_method" => "NA",
            "postal_code" => "NA",
            "city" => "NA",
            "country" => "NA",
            "last_name" => "test",
            "state" => "NA"
        ];
        $data = [
            "auth_token" => $token,
            "amount_cents" => 100 * 100,
            "expiration" => 3600,
            "order_id" => $order->id,
            "billing_data" => $billingData,
            "currency" => "EGP",
            "integration_id" => $integration_id,
        ];
        $response = Http::post('https://accept.paymob.com/api/acceptance/payment_keys', $data);

        return $response->object()->token;


    }

    public function credit($type) {

        if ($type == 'card'){
            $iframe_id = env('PAYMOB_IFRAME_ID_C');
            $integration_id = env('PAYMOB_INTEGRATION_ID_C');
        }elseif($type == 'mobileWallet'){
            $iframe_id = env('PAYMOB_IFRAME_ID_M');
            $integration_id = env('PAYMOB_INTEGRATION_ID_M');
        }

        $token = $this->getToken();
        $order = $this->createOrder($token);
        $paymentToken = $this->getPaymentToken($order, $token ,$integration_id );
        return \Redirect::away('https://portal.weaccept.co/api/acceptance/iframes/'.$iframe_id.'?payment_token='.$paymentToken);

    }

    public function callBack(Request $request)
    {
        $data = $request->all();
        ksort($data);

        $hmac = $data['hmac'];
        $array = [
            'amount_cents',
            'created_at',
            'currency',
            'error_occured',
            'has_parent_transaction',
            'id',
            'integration_id',
            'is_3d_secure',
            'is_auth',
            'is_capture',
            'is_refunded',
            'is_standalone_payment',
            'is_voided',
            'order',
            'owner',
            'pending',
            'source_data_pan',
            'source_data_sub_type',
            'source_data_type',
            'success',
        ];
        $concatenatedString = '';
        foreach ($data as $key => $element){
            if (in_array($key , $array)){
                $concatenatedString .= $element;
            }
        }

        $secrete = env('PAYMOB_HMAC');

        $hashed = hash_hmac('sha512', $concatenatedString , $secrete);
        if ($hashed == $hmac) {
            dd($data , 'Secure');
            echo 'Secure';
        }else{
            echo 'not Secure';
        }
    }
}
