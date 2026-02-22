<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\User;
use App\Services\MockPaymentGateway;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(
        protected Transaction $transaction
    ) {}

    public function backoff(): array
    {
        return [10, 60, 300]; // Exponentially increasing wait times
    }

    public function handle(MockPaymentGateway $gateway): void
    {
        try {
            $result = $gateway->process($this->transaction);

            $this->transaction->update([
                'status' => 'success',
                'external_reference' => $result['external_reference']
            ]);

            Log::info("Payment {$this->transaction->id} processed successfully.");
        } catch (Throwable $e) {
            Log::warning("Payment {$this->transaction->id} failed: " . $e->getMessage());
            throw $e;
        }
    }

    public function failed(Throwable $exception): void
    {
        Log::error("Payment {$this->transaction->id} failed after all retries.");

        DB::transaction(function () {
            $this->transaction->update(['status' => 'failed']);

            // Refund balance on permanent failure
            $user = User::where('id', $this->transaction->user_id)->lockForUpdate()->first();
            if ($user) {
                $totalAmount = $this->transaction->amount + $this->transaction->commission;
                $user->increment('balance', $totalAmount);
                Log::info("Refunded {$totalAmount} to user {$user->id} for failed transaction {$this->transaction->id}");
            }
        });
    }
}
