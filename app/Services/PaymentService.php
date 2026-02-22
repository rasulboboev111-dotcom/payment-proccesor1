<?php

namespace App\Services;

use App\DTOs\PaymentDTO;
use App\Models\Transaction;
use App\Models\User;
use App\Jobs\ProcessPaymentJob;
use Illuminate\Support\Facades\DB;
use App\Exceptions\InsufficientBalanceException;

class PaymentService
{
    private const COMMISSION_RATE = 0.02;

    public function createPayment(PaymentDTO $dto): Transaction
    {
        return DB::transaction(function () use ($dto) {
            // Check for existing idempotency key
            $existing = Transaction::where('idempotency_key', $dto->idempotencyKey)->first();
            if ($existing) {
                return $existing;
            }

            // Pessimistic lock on user balance
            $user = User::where('id', $dto->userId)->lockForUpdate()->firstOrFail();

            $commission = $dto->amount * self::COMMISSION_RATE;
            $totalAmount = $dto->amount + $commission;

            if ($user->balance < $totalAmount) {
                throw new InsufficientBalanceException("Маблағи шумо кам аст.");
            }

            $balanceBefore = $user->balance;
            $balanceAfter = $user->balance - $totalAmount;

            // Create pending transaction
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'amount' => $dto->amount,
                'commission' => $commission,
                'balance_before' => $balanceBefore,
                'balance_after' => $balanceAfter,
                'status' => 'pending',
                'idempotency_key' => $dto->idempotencyKey,
            ]);

            // Deduct balance
            $user->decrement('balance', $totalAmount);

            // Dispatch job for async gateway processing
            ProcessPaymentJob::dispatch($transaction);

            return $transaction;
        });
    }

    public function getTransaction(int $id): Transaction
    {
        return Transaction::findOrFail($id);
    }

    public function getUserBalance(int $userId): float
    {
        return (float) User::findOrFail($userId)->balance;
    }
}
