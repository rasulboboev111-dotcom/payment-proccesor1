<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\TransactionResource;
use App\Services\PaymentService;
use App\DTOs\PaymentDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function store(PaymentRequest $request): JsonResponse
    {
        $idempotencyKey = $request->header('Idempotency-Key');

        if (!$idempotencyKey) {
            return response()->json(['error' => 'Idempotency-Key header is required.'], 400);
        }

        try {
            $dto = PaymentDTO::fromRequest($request->validated(), $idempotencyKey);
            $transaction = $this->paymentService->createPayment($dto);

            return (new TransactionResource($transaction))
                ->response()
                ->setStatusCode(201);
        } catch (\App\Exceptions\InsufficientBalanceException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        } catch (\Throwable $e) {
            Log::error("Payment creation failed: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }

    public function show(int $id): TransactionResource
    {
        $transaction = $this->paymentService->getTransaction($id);
        return new TransactionResource($transaction);
    }
}
