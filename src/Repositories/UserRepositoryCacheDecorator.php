<?php namespace Tukecx\Base\Users\Repositories;

use Tukecx\Base\Caching\Repositories\Eloquent\EloquentBaseRepositoryCacheDecorator;
use Tukecx\Base\Caching\Repositories\Traits\EloquentUseSoftDeletesCache;
use Tukecx\Base\Users\Models\User;
use Tukecx\Base\Users\Repositories\Contracts\UserRepositoryContract;

class UserRepositoryCacheDecorator extends EloquentBaseRepositoryCacheDecorator implements UserRepositoryContract
{
    use EloquentUseSoftDeletesCache;

    /**
     * @param \Tukecx\Base\Users\Models\User $user
     */
    public function getRoles($user)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function createUser(array $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param $id
     * @param array $data
     * @param bool $withEvent
     * @return array
     */
    public function updateUser($id, array $data, $withEvent = true)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param \Tukecx\Base\Users\Models\User $model
     * @param \Illuminate\Database\Eloquent\Collection|array $data
     */
    public function syncRoles($model, $data)
    {
        return $this->afterUpdate(__FUNCTION__, func_get_args());
    }

    /**
     * @param User|int $id
     * @return bool
     */
    public function isSuperAdmin($id)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param User|int $id
     * @param array $permissions
     * @return bool
     */
    public function hasPermission($id, array $permissions)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }

    /**
     * @param User|int $id
     * @param array $roles
     * @return bool
     */
    public function hasRole($id, array $roles)
    {
        return $this->beforeGet(__FUNCTION__, func_get_args());
    }
}
