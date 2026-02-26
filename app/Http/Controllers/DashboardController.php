<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'balance')->get();
        $recentTransactions = Transaction::with(['user' => function($query) {
            $query->select('id', 'name');
        }])->select('id', 'user_id', 'type', 'amount', 'commission', 'balance_before', 'balance_after', 'status', 'external_reference', 'created_at')
          ->latest()
          ->take(5)
          ->get();

        // Cache stats for 60 seconds to avoid repeated heavy queries
        $stats = Cache::remember('dashboard_stats', 60, function () {
            $last30Days = now()->subDays(30);
            
            $dailyStats = Transaction::where('status', 'success')
                ->where('created_at', '>=', $last30Days)
                ->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount, SUM(commission) as total_commission')
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return [
                'total_volume' => Transaction::where('status', 'success')->sum('amount'),
                'total_commission' => Transaction::where('status', 'success')->sum('commission'),
                'active_users_count' => User::count(),
                'daily_stats' => $dailyStats
            ];
        });

        return Inertia::render('Dashboard', [
            'users' => $users,
            'recentTransactions' => $recentTransactions,
            'stats' => $stats
        ]);
    }

    public function createPayment()
    {
        return Inertia::render('Payments/Create', [
            'users' => User::select('id', 'name', 'balance')->get()
        ]);
    }

    public function transactions()
    {
        return Inertia::render('Transactions/Index', [
            'transactions' => Transaction::with(['user' => function($query) {
                $query->select('id', 'name');
            }])->select('id', 'user_id', 'type', 'amount', 'commission', 'balance_before', 'balance_after', 'status', 'external_reference', 'created_at')
              ->latest()
              ->paginate(10)
        ]);
    }
}
