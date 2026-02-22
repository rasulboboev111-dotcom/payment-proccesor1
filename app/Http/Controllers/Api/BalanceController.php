<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function show(int $id): JsonResponse
    {
        $balance = $this->paymentService->getUserBalance($id);
        return response()->json(['user_id' => $id, 'balance' => $balance]);
    }
}
