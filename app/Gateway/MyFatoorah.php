<?php

namespace App\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Omnipay\Omnipay;

class MyFatoorah
{
    public static function redirect_if_payment_success()
    {
        if (Session::has('call_back')) {
            return url(Session::get('call_back')['success']);
        }
    }

    public static function redirect_if_payment_faild()
    {
        if (Session::has('call_back')) {
            return url(Session::get('call_back')['fail']);
        }
    }

    public static function fallback()
    {
        return url('payment/myfatoorah');
    }

    public static function make_payment($array)
    {
        $api_key = $array['api_key'];

        $currency = $array['currency'];
        $email = $array['email'];
        $amount = round($array['pay_amount']);
        $name = $array['name'];
        $test_mode = $array['test_mode'];
        $billName = $array['billName'];
        $data['api_key'] = $api_key;

        $data['payment_mode'] = 'myfatoorah';

        $data['amount'] = $amount;
        $data['test_mode'] = $test_mode;
        $data['charge'] = $array['charge'];
        $data['main_amount'] = $array['amount'];
        $data['getway_id'] = $array['getway_id'];
        $data['payment_type'] = $array['payment_type'] ?? '';
        $data['order_ref'] = Str::random(5).now()->timestamp;

        if ($test_mode == 0) {
            $data['env'] = false;
            $test_mode = false;
            $final = str_replace(',', '', number_format($amount, 3));
        } else {
            $data['env'] = true;
            $test_mode = true;
            $final = str_replace(',', '', number_format($amount / 100, 3));
        }

        Session::put('myfatoorah_credentials', $data);
        $gateway = Omnipay::create('Myfatoorah');
        $gateway->setApiKey($api_key);
        $gateway->setTestMode($test_mode);

        $firstName = explode(' ', $name)[0];
        $lastName = explode(' ', $name)[1] ?? '';

        $response = $gateway->purchase([
            'Amount' => $final,
            'OrderRef' => $data['order_ref'],
            'Currency' => strtoupper($currency),
            'returnUrl' => MyFatoorah::fallback(),
            'cancelUrl' => MyFatoorah::redirect_if_payment_faild(),
            'Card' => [
                'firstName' => $firstName,
                'lastName' => $lastName,
                'email' => $email,
            ],
        ])->send();

        if ($response->isSuccessful() && $response->isRedirect()) {
            return redirect($response->getRedirectUrl());
        } else {
            // not successful
            return redirect(MyFatoorah::redirect_if_payment_faild());
        }
    }

    public function status(Request $request)
    {
        abort_if(! Session::has('myfatoorah_credentials'), 404);

        $credentials = Session::get('myfatoorah_credentials');
        $gateway = Omnipay::create('Myfatoorah');
        $gateway->setApiKey($credentials['api_key']);
        $gateway->setTestMode($credentials['env']);

        $request = $request->all();

        $response = $gateway->completePurchase([
            'paymentId' => $request['paymentId'],
        ])->send();

        if ($response->isSuccessful()) {
            $paymentData = $response->getMessage();
            $paymentData = json_decode($paymentData, true);
            $paymentData = $paymentData['Data'];


            $data['payment_id'] = $response->getTransactionReference();
            $data['payment_method'] = 'myfatoorah';
            $data['getway_id'] = $credentials['getway_id'];

            $data['amount'] = $credentials['main_amount'];
            $data['charge'] = $credentials['charge'];
            $data['status'] = $paymentData['InvoiceStatus'] == 'Paid' ? 1 : 2;
            $data['payment_status'] = $paymentData['InvoiceStatus'] == 'Paid';

            Session::put('payment_info', $data);
            Session::forget('myfatoorah_credentials');

            return redirect(MyFatoorah::redirect_if_payment_success());
        } else {
            $data['payment_status'] = 0;
            Session::put('payment_info', $data);
            Session::forget('myfatoorah_credentials');

            return redirect(MyFatoorah::redirect_if_payment_faild());
        }
    }
}
