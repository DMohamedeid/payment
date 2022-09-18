<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class KashierController extends Controller
{
    //Copy and paste this code in your Backend
    public function generateKashierOrderHash(){
        $mid = "MID-14423-347"; //your merchant id
        $amount = 100; //eg: 100
        $currency = "EGP"; //eg: "EGP"
        $orderId = 337; //eg: 99, your system order ID
        $secret = "488d7333-78f7-4374-99d7-86e85ea7ed80";

        $path = "/?payment=".$mid.".".$orderId.".".$amount.".".$currency;
        $hash = hash_hmac( 'sha256' , $path , $secret ,false);

//        return view('kashier_payment',compact('hash','mid','amount' , 'currency' , 'orderId' ,'secret'));

        $url = "https://checkout.kashier.io/?amount=$amount&hash=$hash&currency=$currency&orderId=$orderId&merchantId=$mid&mode=test&merchantRedirect=". route('kashier.validateSignature') . "&type=external&display=ar";
        return redirect($url);

    }
//The Result Hash for /?payment=mid-0-1.99.20.EGP with secret 11111 should result 606a8a1307d64caf4e2e9bb724738f115a8972c27eccb2a8acd9194c357e4bec
    public function validateSignature(Request $request)
    {
        $queryString = "";
        $secret      = '488d7333-78f7-4374-99d7-86e85ea7ed80';
        foreach ( $_GET as $key => $value ) {
            if ( $key == "signature" || $key == "mode" ) {
                continue;
            }
            $queryString = $queryString . "&" . $key . "=" . $value;
        }

        $queryString = ltrim( $queryString, $queryString[0] );
        $signature   = hash_hmac( 'sha256', $queryString, $secret, false );

        if ( $signature == $_GET["signature"] ) {
            return view('welcome')->with('success','the payment is successfully');
        } else {
            echo "Failed signature";
        }

    }

    public function success(Request $request)
    {
        $data = [];

//        $data['paymentStatus'] = 'paymentStatus';
//        $data['merchantOrderId'] = 'merchantOrderId';
//        $data['currency'] = 'currency';
//        $data['amount'] = 'amount';
        dd($request);
    }
}
