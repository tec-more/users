<?php namespace Tukecx\Base\Users\Hook;

use Tukecx\Base\Users\Repositories\Contracts\UserRepositoryContract;
use Tukecx\Base\Users\Repositories\UserRepository;

class RegisterDashboardStats
{
    /**
     * @var UserRepository
     */
    protected $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function handle()
    {
        echo view('tukecx-users::admin.dashboard-stats.stat-box', [
            'count' => $this->repository->count(),
        ]);
    }
}
