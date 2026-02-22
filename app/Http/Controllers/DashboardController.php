<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        // Analytics Data
        $last30Days = now()->subDays(30);
        
        $dailyStats = Transaction::where('status', 'success')
            ->where('created_at', '>=', $last30Days)
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount, SUM(commission) as total_commission')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $stats = [
            'total_volume' => Transaction::where('status', 'success')->sum('amount'),
            'total_commission' => Transaction::where('status', 'success')->sum('commission'),
            'active_users_count' => User::count(),
            'daily_stats' => $dailyStats
        ];

        return Inertia::render('Dashboard', [
            'users' => $users,
            'recentTransactions' => $recentTransactions,
            'stats' => $stats
        ]);
    }

    public function createPayment()
    {
        return Inertia::render('Payments/Create', [
            'users' => User::all()
        ]);
    }

    public function transactions()
    {
        return Inertia::render('Transactions/Index', [
            'transactions' => Transaction::with('user')->latest()->get()
        ]);
    }
}
