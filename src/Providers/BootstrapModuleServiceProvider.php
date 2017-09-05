<?php namespace Tukecx\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapModuleServiceProvider extends ServiceProvider
{
    protected $module = 'Tukecx\Base\Users';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app()->booted(function () {
            $this->booted();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

    private function booted()
    {
        /**
         * Register to dashboard menu
         */
        \DashboardMenu::registerItem([
            'id' => 'tukecx-users',
            'priority' => 3,
            'parent_id' => null,
            'heading' => '管理员&权限',
            'title' => '管理员',
            'font_icon' => 'icon-users',
            'link' => route('admin::users.index.get'),
            'css_class' => null,
            'permissions' => ['view-users'],
        ]);
    }
}
