<?php namespace Tukecx\Base\Users\Providers;

use Illuminate\Support\ServiceProvider;
use Tukecx\Base\Users\Models\User;
use Tukecx\Base\Users\Repositories\UserRepositoryCacheDecorator;
use Tukecx\Base\Users\Repositories\UserRepository;
use Tukecx\Base\Users\Repositories\Contracts\UserRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryContract::class, function () {
            $repository = new UserRepository(new User);

            if (config('tukecx-caching.repository.enabled')) {
                return new UserRepositoryCacheDecorator($repository);
            }

            return $repository;
        });
    }
}
