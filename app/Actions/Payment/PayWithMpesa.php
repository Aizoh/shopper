<?php

declare(strict_types=1);

namespace App\Actions\Payment;

use App\Contracts\ManageOrder;
use App\Http\Controllers\MPesaController;
use App\Models\MPesa;
use Illuminate\Support\Facades\Log;
use Shopper\Core\Models\Order;

class PayWithMpesa implements ManageOrder
{
    public function handle(Order $order, array $data = []): mixed
    {
        session()->forget('checkout');

        //record an mpesa transaction table
        try {
            // Ensure required Mpesa details are provided
            if (!isset($data['phone_number'])) {
                throw new \Exception('Mpesa payment requires a phone number and transaction ID.');
            }

            // Store Mpesa payment details
            // MPesa::create([
            //     'order_id' => $order->id,
            //     'phone_number' => $data['phone_number'],
                
            //     'amount' => $order->total, // Assuming your order has a total field
            //     'status' => $data['status'] ?? 'pending', // Default status
            // ]);

            // Optionally update order status
            // $order->update(['payment_status' => 'pending']);
            $mpesa = new MPesaController();
            $mpesa->stk_push();

            Log::info('Mpesa payment initiated', ['order_id' => $order->id]);
        } catch (\Exception $e) {
            Log::error('Mpesa payment failed: ' . $e->getMessage());
        }

        return redirect()->route('order-confirmed', ['number' => $order->number]);
    }
}
