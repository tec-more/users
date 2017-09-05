<?php namespace Tukecx\Base\Users\Repositories\Contracts;

use Tukecx\Base\Users\Models\User;

interface UserRepositoryContract
{
    /**
     * @param array $data
     * @return mixed
     */
    public function createUser(array $data);

    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function updateUser($id, array $data);

    /**
     * @param mixed $model
     * @param \Illuminate\Database\Eloquent\Collection|array $data
     */
    public function syncRoles($model, $data);

    /**
     * @param $user
     * @return mixed
     */
    public function getRoles($user);

    /**
     * @param User|int $id
     * @param array $permissions
     * @return bool
     */
    public function hasPermission($id, array $permissions);

    /**
     * @param User|int $id
     * @param array $roles
     * @return bool
     */
    public function hasRole($id, array $roles);
}
