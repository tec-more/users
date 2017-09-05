<?php namespace Tukecx\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Users\Hook\RegisterDashboardStats;

class HookServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        add_action('tukecx-dashboard.index.stat-boxes.get', [RegisterDashboardStats::class, 'handle'], 24);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
