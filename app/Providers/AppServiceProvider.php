<?php

namespace App\Providers;

use App\Models\ContactMessage;
use App\Models\EstimateInquiry;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sidebar badges in the admin panel.
        View::composer('admin.layouts.app', function ($view) {
            $view->with('navCounts', [
                'inquiries' => Schema::hasTable('estimate_inquiries') ? EstimateInquiry::where('status', 'new')->count() : 0,
                'messages'  => Schema::hasTable('contact_messages') ? ContactMessage::where('is_read', false)->count() : 0,
            ]);
        });
    }
}
