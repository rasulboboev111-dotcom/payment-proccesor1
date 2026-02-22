<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HealthController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo();
            Redis::connection()->ping();

            return response()->json([
                'status' => 'ok',
                'database' => 'connected',
                'redis' => 'connected',
                'timestamp' => now()->toIso8601String()
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 503);
        }
    }
}
