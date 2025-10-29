<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\PaymentGatewayInterface;
use App\Services\SaudiPaymentGateway;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PaymentGatewayInterface::class, SaudiPaymentGateway::class);
    }

    public function boot(): void
    {
        // Share categories with all views for navigation
        try {
            view()->composer('*', function ($view) {
                try {
                    // Skip admin views
                    if ($view->getName() && (
                        strpos($view->getName(), 'admin') !== false ||
                        strpos($view->getName(), 'errors') !== false ||
                        strpos($view->getName(), 'auth') !== false
                    )) {
                        return;
                    }
                    
                    // Get navigation categories
                    $navCategories = \App\Models\Category::where('is_active', true)
                        ->whereNull('parent_id')
                        ->orderBy('sort_order')
                        ->orderBy('name_ar')
                        ->take(8)
                        ->get();
                    
                    $view->with('navCategories', $navCategories);
                } catch (\Exception $e) {
                    // If database not ready, provide empty collection
                    $view->with('navCategories', collect());
                }
            });
        } catch (\Exception $e) {
            // Silently fail during boot if database not ready
            \Log::warning('AppServiceProvider boot failed: ' . $e->getMessage());
        }
    }
}

