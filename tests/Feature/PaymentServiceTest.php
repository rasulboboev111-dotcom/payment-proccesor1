<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Transaction;
use App\Services\PaymentService;
use App\DTOs\PaymentDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Queue;
use App\Jobs\ProcessPaymentJob;

class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;

    private PaymentService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PaymentService();
    }

    public function test_create_payment_deducts_balance_and_dispatches_job()
    {
        Queue::fake();

        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'balance' => 100.00
        ]);

        $dto = new PaymentDTO($user->id, 50.00, 'unique-key-1');
        $transaction = $this->service->createPayment($dto);

        // 50 + 2% (1) = 51
        $this->assertEquals(49.00, $user->fresh()->balance);
        $this->assertEquals('pending', $transaction->status);
        $this->assertEquals(50.00, $transaction->amount);
        $this->assertEquals(1.00, $transaction->commission);

        Queue::assertPushed(ProcessPaymentJob::class);
    }

    public function test_payment_idempotency()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'balance' => 100.00
        ]);

        $dto = new PaymentDTO($user->id, 10.00, 'same-key');

        $t1 = $this->service->createPayment($dto);
        $t2 = $this->service->createPayment($dto);

        $this->assertEquals($t1->id, $t2->id);
        $this->assertEquals(89.80, $user->fresh()->balance); // (10 + 0.2) only once
    }

    public function test_insufficient_balance_throws_exception()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'balance' => 5.00
        ]);

        $this->expectException(\App\Exceptions\InsufficientBalanceException::class);

        $dto = new PaymentDTO($user->id, 10.00, 'key');
        $this->service->createPayment($dto);
    }
}
