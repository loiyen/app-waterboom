<?php

namespace App\Services;

use App\Models\Orders;
use App\Models\Transactions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Exception;

class XenditService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.xendit.api_key');
    }

    public function createQrisTransaction(Orders $order)
    {
        try {
            $externalId = $order->order_code ?? 'ORD-' . Str::uuid();
            $grossAmount = $order->gross;

          
            $ticketItems = $order->items->map(fn($item) => [
                'name'     => $item->ticket->name ?? 'Tiket',
                'quantity' => (int) $item->qty,
                'price'    => (float) $item->price,
            ])->toArray();

           
            $serviceItems = $order->serviceItem->map(fn($srv) => [
                'name'     => $srv->service->name ?? 'Layanan Tambahan',
                'quantity' => (int) $srv->qty_service,
                'price'    => (float) $srv->price_service,
            ])->toArray();

           
            $allItems = array_merge($ticketItems, $serviceItems);

           
            $payload = [
                'external_id' => $externalId,
                'amount' => $grossAmount,
                'description' => 'Pembayaran Order #' . $externalId,
                'currency' => 'IDR',
                'invoice_duration' => 600, // 10 menit
                'customer' => [
                    'given_names' => $order->customer->name ?? 'Customer',
                    'email' => $order->customer->email ?? 'customer@example.com',
                    'mobile_number' => $order->customer->phone ?? '08123456789',
                ],
                'customer_notification_preference' => [
                    'invoice_created' => ['email'],
                    'invoice_paid' => ['email'],
                    'invoice_expired' => ['email'],
                ],
                'success_redirect_url' => url('/payment-success'),
                'failure_redirect_url' => url('/payment-failure'),
                'items' => $allItems,
                'fees' => [
                    [
                        'type' => 'PPN',
                        'value' => 4000,
                    ],
                ],
                'payment_methods' => ['QRIS'],
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ];

            $headers = [
                'api-version' => "2022-07-31",
                'Content-Type' => 'application/json',
            ];

            $response = Http::withBasicAuth($this->apiKey, '')
                ->withHeaders($headers)
                ->post('https://api.xendit.co/v2/invoices', $payload);

            if ($response->failed()) {
                Log::error('Xendit API Error:', ['response' => $response->body()]);
                throw new Exception('Xendit API error: ' . $response->body());
            }

            $result = $response->json();
            Log::info('Xendit Response:', $result);

            $expiry = isset($result['expiry_date'])
                ? Carbon::parse($result['expiry_date'])
                ->setTimezone('Asia/Jakarta')
                ->format('Y-m-d H:i:s')
                : null;

            $transaction = Transactions::create([
                'orders_id'          => $order->id,
                'xendit_external_id' => $externalId,
                'payment_type'       => 'qris',
                'transaction_status' => 'PENDING',
                'gross_amount'       => $grossAmount,
                'invoice_url'        => $result['invoice_url'] ?? null,
                'expiry_time'        => $expiry,
            ]);

            return $transaction;
        } catch (Exception $e) {
            Log::error('XenditService Error:', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
}
