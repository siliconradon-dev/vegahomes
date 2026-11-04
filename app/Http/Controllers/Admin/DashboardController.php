<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\DesignInquiry;
use App\Models\EstimateInquiry;
use App\Models\NewsletterSubscriber;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'       => EstimateInquiry::count(),
            'new'         => EstimateInquiry::where('status', 'new')->count(),
            'this_month'  => EstimateInquiry::where('created_at', '>=', now()->startOfMonth())->count(),
            'won'         => EstimateInquiry::where('status', 'won')->count(),
            'pipeline'    => (int) EstimateInquiry::whereNotIn('status', ['won', 'lost'])->sum('estimated_cost'),
            'design_new'   => DesignInquiry::where('status', 'new')->count(),
            'design_total' => DesignInquiry::count(),
            'design_fees'  => (int) DesignInquiry::whereNotIn('status', ['won', 'lost'])->sum('design_fee'),
            'messages'    => ContactMessage::where('is_read', false)->count(),
            'subscribers' => NewsletterSubscriber::count(),
        ];

        // Enquiries for the last 6 months (database-agnostic grouping)
        $from   = now()->subMonths(5)->startOfMonth();
        $counts = EstimateInquiry::where('created_at', '>=', $from)->get(['created_at'])
            ->groupBy(fn ($row) => $row->created_at->format('Y-m'))
            ->map->count();

        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $m        = now()->subMonths($i);
            $months[] = ['label' => $m->format('M'), 'value' => (int) ($counts[$m->format('Y-m')] ?? 0)];
        }

        $byPackage = EstimateInquiry::selectRaw('package_name, count(*) as aggregate')
            ->groupBy('package_name')
            ->orderByDesc('aggregate')
            ->pluck('aggregate', 'package_name');

        $byStatus = EstimateInquiry::selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        return view('admin.dashboard', [
            'stats'     => $stats,
            'months'    => $months,
            'byPackage' => $byPackage,
            'byStatus'  => $byStatus,
            'recent'    => EstimateInquiry::latest()->limit(8)->get(),
            'recentDesign' => DesignInquiry::latest()->limit(6)->get(),
        ]);
    }
}
