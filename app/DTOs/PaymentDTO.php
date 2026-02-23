<?php

namespace App\DTOs;

class PaymentDTO
{
    public function __construct(
        public int $userId,
        public float $amount,
        public string $type,
        public string $idempotencyKey
    ) {}

    public static function fromRequest(array $data, string $idempotencyKey): self
    {
        return new self(
            userId: (int) $data['user_id'],
            amount: (float) $data['amount'],
            type: (string) ($data['type'] ?? 'withdrawal'),
            idempotencyKey: $idempotencyKey
        );
    }
}
