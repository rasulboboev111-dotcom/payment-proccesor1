<?php

namespace App\Services;

use App\Models\Transaction;
use Exception;

class MockPaymentGateway
{
    /**
     * @throws Exception
     */
    public function process(Transaction $transaction): array
    {
        $rand = rand(1, 100);

        if ($rand <= 25) {
            throw new Exception("Gateway error: Payment rejected.");
        }

        if ($rand <= 35) { // 25 + 10 = 35
            throw new Exception("Gateway timeout: Connection lost.", 408);
        }

        return [
            'external_reference' => 'EXT-' . strtoupper(uniqid()),
            'status' => 'success'
        ];
    }
}
