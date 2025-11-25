<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;

class XenditCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        Log::info('📩 Xendit Callback Received', $request->all());

        $orderToEmail = null; // order yang akan dikirim email setelah transaction

        $externalId = $request->input('external_id');
        $status = strtoupper($request->input('status', ''));
        $paidAt = $request->input('paid_at');

        $receivedToken = $request->header('X-CALLBACK-TOKEN')
            ?? $request->header('x-callback-token');
        $expectedToken = config('services.xendit.callback_token');

        if (!$receivedToken || $receivedToken !== $expectedToken) {
            Log::warning('Invalid Xendit Callback Token', [
                'received' => $receivedToken,
                'expected' => $expectedToken,
            ]);
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$externalId) {
            Log::warning('Invalid Callback: missing external_id');
            return response()->json(['message' => 'Invalid callback'], 400);
        }

        try {
            DB::transaction(function () use ($externalId, $status, $paidAt, &$orderToEmail) {

                $transaction = Transactions::with('order')
                    ->lockForUpdate()
                    ->where('xendit_external_id', $externalId)
                    ->first();

                if (!$transaction) {
                    Log::error('Transaction Not Found', ['external_id' => $externalId]);
                    throw new \Exception('Transaction not found');
                }

                $transaction->transaction_status = strtolower($status);
                $transaction->transaction_time = $paidAt ? now()->parse($paidAt) : now();
                $transaction->save();

                if ($transaction->order) {
                    $order = $transaction->order;

                    Log::info('Order ditemukan untuk transaksi', ['order_id' => $order->id]);

                    $paymentStatus = match ($status) {
                        'PAID'    => 'paid',
                        'EXPIRED' => 'expired',
                        'FAILED'  => 'failed',
                        default   => $order->payment_status,
                    };

                    if ($order->payment_status !== $paymentStatus) {
                        $order->payment_status = $paymentStatus;
                        $order->save();

                        Log::info('Order payment_status updated', [
                            'order_id' => $order->id,
                            'new_status' => $paymentStatus,
                        ]);

                        // Jika status PAID → kirim email setelah transaction selesai
                        if ($paymentStatus === 'paid') {
                            $orderToEmail = $order;
                        }
                    }
                } else {
                    Log::warning('Order tidak ditemukan untuk transaksi', [
                        'transaction_id' => $transaction->id,
                    ]);
                }

                Log::info('Xendit Callback Updated Successfully', [
                    'external_id' => $externalId,
                    'status' => $status,
                ]);
            });

            /**
             * ==========================
             *   KIRIM EMAIL DI SINI
             * ==========================
             */
            if ($orderToEmail) {
                try {
                    Mail::to($orderToEmail->customer->email)
                        ->send(new TicketMail($orderToEmail));

                    Log::info('E-ticket email sent', [
                        'order_id' => $orderToEmail->id
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Email sending failed', [
                        'error' => $e->getMessage()
                    ]);
                }
            }

            return response()->json(['message' => 'Callback processed successfully'], 200);

        } catch (\Throwable $e) {
            Log::error('Xendit Callback Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
