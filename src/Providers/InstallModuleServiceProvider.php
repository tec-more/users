<?php namespace Tukecx\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;

class InstallModuleServiceProvider extends ServiceProvider
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
        acl_permission()
            ->registerPermission('View users', 'view-users', $this->module)
            ->registerPermission('Create users', 'create-users', $this->module)
            ->registerPermission('Edit other users', 'edit-other-users', $this->module)
            ->registerPermission('Delete users', 'delete-users', $this->module)
            ->registerPermission('Force delete users', 'force-delete-users', $this->module);
    }
}
