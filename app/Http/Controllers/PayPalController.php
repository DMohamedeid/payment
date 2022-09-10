<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    public function goPayment()
    {
        return view('Product.payment');
    }
    public function payment()
    {
        $data = [];
        $data['items'] = [
            [
                'name'        => 'Apple',
                'price'       => 100,
                'description' => 'Macbook pro 14 inc',
                'qty'         => 1,
            ]
        ];
        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payPal.success');
        $data['cancel_url'] = route('payPal.cancel');
        $data['total'] = 100;

        $provider = new ExpressCheckout();

        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data,true);

        return redirect($response['paypal_link']);
    }

    public function cancel()
    {
        dd('You are Canceled This Payment');
    }

    public function success(Request $request)
    {
        $provider = new ExpressCheckout();

        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper( $response['ACK'] ),['SUCCESS' , 'SUCCESSWITHWARNING'] ))
        {
            dd('Your Payment Was Successfully');
        }

        dd('please try again');
    }
}
