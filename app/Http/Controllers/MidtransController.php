<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{

    public function handleNotification(Request $request)
    {
        $notificationBody = json_decode($request->getContent(), true);

        // Log notification for debugging
        Log::info('Midtrans notification received: ' . json_encode($notificationBody));

        // Get order ID from notification
        $orderId = $notificationBody['order_id'] ?? null;

        // Find transaction by midtrans_order_id or by ID if order_id is in format TRX-{id}
        $transaction = null;
        if (strpos($orderId, 'TRX-') === 0) {
            // Extract ID from TRX-{id} format
            $id = substr($orderId, 4);
            $transaction = Transaksi::find($id);
        } else {
            $transaction = Transaksi::where('midtrans_order_id', $orderId)->first();
        }

        if (!$transaction) {
            Log::error('Transaction not found for order ID: ' . $orderId);
            return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
        }

        // Get transaction status and payment type
        $transactionStatus = $notificationBody['transaction_status'] ?? null;
        $paymentType = $notificationBody['payment_type'] ?? null;

        // For payment types with specific method (like virtual account)
        $bankName = null;
        if (isset($notificationBody['va_numbers'][0]['bank'])) {
            $bankName = $notificationBody['va_numbers'][0]['bank'];
        } elseif (isset($notificationBody['permata_va_number'])) {
            $bankName = 'permata';
        } elseif (isset($notificationBody['bca_va_number'])) {
            $bankName = 'bca';
        } elseif (isset($notificationBody['bni_va_number'])) {
            $bankName = 'bni';
        } elseif (isset($notificationBody['bri_va_number'])) {
            $bankName = 'bri';
        } elseif (isset($notificationBody['payment_code'])) {
            if ($paymentType == 'echannel') {
                $bankName = 'mandiri';
            } elseif ($paymentType == 'cstore') {
                $bankName = $notificationBody['store'] ?? null;
            }
        }

        // Format payment method nicely
        $paymentMethod = $this->formatPaymentMethod($paymentType, $bankName);

        // Update transaction based on status
        if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
            // Payment success
            $transaction->update([
                'status' => 'success',
                'metode_pembayaran' => $paymentMethod
            ]);

            Log::info('Transaction updated to success: ' . $orderId);
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            // Payment failed
            $transaction->update([
                'status' => 'failed',
                'metode_pembayaran' => $paymentMethod
            ]);

            Log::info('Transaction updated to failed: ' . $orderId);
        } elseif ($transactionStatus == 'pending') {
            // Payment pending
            $transaction->update([
                'metode_pembayaran' => $paymentMethod
            ]);

            Log::info('Transaction updated with payment method: ' . $orderId);
        }

        return response()->json(['status' => 'success']);
    }


    private function formatPaymentMethod($paymentType, $bankName = null)
    {
        $paymentMethods = [
            'credit_card' => 'Kartu Kredit',
            'bank_transfer' => 'Transfer Bank',
            'echannel' => 'Mandiri Bill Payment',
            'bca_klikpay' => 'BCA KlikPay',
            'bca_klikbca' => 'BCA KlikBCA',
            'cstore' => 'Convenience Store',
            'gopay' => 'GoPay',
            'shopeepay' => 'ShopeePay',
            'qris' => 'QRIS',
        ];

        $bankNames = [
            'bca' => 'BCA',
            'bni' => 'BNI',
            'bri' => 'BRI',
            'permata' => 'Permata',
            'mandiri' => 'Mandiri',
            'indomaret' => 'Indomaret',
            'alfamart' => 'Alfamart',
        ];

        // Default payment method
        $method = $paymentMethods[$paymentType] ?? ucfirst($paymentType);

        // Add bank name if available
        if ($bankName && isset($bankNames[$bankName])) {
            if ($paymentType == 'bank_transfer' || $paymentType == 'echannel') {
                $method = 'Transfer ' . $bankNames[$bankName];
            } elseif ($paymentType == 'cstore') {
                $method = $bankNames[$bankName];
            }
        }

        return $method;
    }
}
