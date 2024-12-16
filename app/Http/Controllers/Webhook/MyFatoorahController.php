<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MyFatoorahController extends Controller
{
    public function index(Request $request)
    {
        $eventType = $request->input('Event');
        $method = 'handle'.Str::studly(str_replace('.', '_', $eventType));

        file_put_contents(storage_path('logs/myfatoorah.json'), $request->all());
        if (method_exists($this, $method)) {
            return $this->{$method}($request);
        }
    }

    private function handleTransactionsStatusChanged(Request $request)
    {
        $paymentId = $request->input('Data.InvoiceId');
        $status = $request->input('Data.TransactionStatus');

        // Update your database with the new status
        $order = Order::where('payment_id', $paymentId)->firstOrFail();
        $order->update([
            'status' => $this->getTransactionStatus($status),
        ]);
    }

    private function getTransactionStatus($status)
    {
        if ($status === 'SUCCESS') {
            return 1;
        }elseif (in_array($status, ['FAILED', 'CANCELED'])) {
            return 2;
        }elseif ($status === 'AUTHORIZE') {
            return 0;
        }
    }
}
