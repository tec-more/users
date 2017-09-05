<?php namespace Tukecx\Base\Users\Repositories;

use Tukecx\Base\Caching\Services\Traits\Cacheable;
use Tukecx\Base\Caching\Services\Contracts\CacheableContract;
use Tukecx\Base\Core\Repositories\Eloquent\Traits\EloquentUseSoftDeletes;
use Tukecx\Base\Core\Repositories\Eloquent\EloquentBaseRepository;
use Tukecx\Base\Users\Models\Contracts\UserModelContract;
use Tukecx\Base\Users\Models\User;
use Tukecx\Base\Users\Repositories\Contracts\UserRepositoryContract;

class UserRepository extends EloquentBaseRepository implements UserRepositoryContract, CacheableContract
{
    use Cacheable;

    use EloquentUseSoftDeletes;

    protected $rules = [
        'username' => 'required|between:3,100|string|unique:users|alpha_dash',
        'email' => 'required|between:5,255|email|unique:users',
        'password' => 'required|max:60|min:5|string',
        'status' => 'string|required|in:activated,disabled,deleted',
        'display_name' => 'string|between:1,150|nullable',
        'first_name' => 'string|between:1,100|required',
        'last_name' => 'string|between:1,100|nullable',
        'avatar' => 'string|between:1,150|nullable',
        'phone' => 'string|max:20|nullable',
        'mobile_phone' => 'string|max:20|nullable',
        'sex' => 'string|required|in:male,female,other',
        'birthday' => 'date_multi_format:Y-m-d H:i:s,Y-m-d|nullable',
        'description' => 'string|max:1000|nullable',
        'created_by' => 'integer|required|min:0',
        'updated_by' => 'integer|min:0',
        'last_login_at' => 'string|date_format:Y-m-d H:i:s',
        'last_activity_at' => 'string|date_format:Y-m-d H:i:s',
        'disabled_until' => 'string|date_format:Y-m-d H:i:s',
        'deleted_at' => 'string|date_format:Y-m-d H:i:s',
    ];

    protected $editableFields = [
        'username',
        'email',
        'password',
        'status',
        'display_name',
        'first_name',
        'last_name',
        'avatar',
        'phone',
        'mobile_phone',
        'sex',
        'birthday',
        'description',
        'created_by',
        'updated_by',
        'last_login_at',
        'last_activity_at',
        'disabled_until',
        'deleted_at',
    ];

    /**
     * @param \Tukecx\Base\Users\Models\User $model
     * @param \Illuminate\Database\Eloquent\Collection|array $data
     */
    public function syncRoles($model, $data)
    {
        $model->roles()->sync($data);

        return $this;
    }

    /**
     * @param \Tukecx\Base\Users\Models\User $user
     */
    public function getRoles($user)
    {
        if ($user) {
            return $user->roles()->get();
        }
        return collect([]);
    }

    /**
     * @param array $data
     * @return array
     */
    public function createUser(array $data)
    {
        $resultEditObject = $this->editWithValidate(0, $data, true, false);

        if ($resultEditObject['error']) {
            return response_with_messages($resultEditObject['messages'], true, \Constants::ERROR_CODE);
        }
        $object = $resultEditObject['data'];

        $result = response_with_messages('User created successfully', false, \Constants::SUCCESS_CODE, $object);

        return $result;
    }

    /**
     * @param $id
     * @param array $data
     * @return array
     */
    public function updateUser($id, array $data)
    {
        $resultEditObject = $this->editWithValidate($id, $data, false, true);

        if ($resultEditObject['error']) {
            return response_with_messages($resultEditObject['messages'], true, \Constants::ERROR_CODE);
        }
        $object = $resultEditObject['data'];

        if (isset($data['roles']) && is_array($data['roles'])) {
            $this->syncRoles($object, $data['roles']);
        }

        $result = response_with_messages('User updated successfully', false, \Constants::SUCCESS_CODE, $object);

        return $result;
    }

    /**
     * @param User|int $id
     * @return bool
     */
    public function isSuperAdmin($id)
    {
        if ($id instanceof UserModelContract) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }

        if (!$model) {
            return false;
        }

        if (!$model->isSuperAdmin()) {
            return false;
        }

        return true;
    }

    /**
     * @param User|int $id
     * @param array $permissions
     * @return bool
     */
    public function hasPermission($id, array $permissions)
    {
        if ($id instanceof UserModelContract) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }

        if (!$model) {
            return false;
        }

        if (!$model->hasPermission($permissions)) {
            return false;
        }

        return true;
    }

    /**
     * @param User|int $id
     * @param array $roles
     * @return bool
     */
    public function hasRole($id, array $roles)
    {
        if ($id instanceof UserModelContract) {
            $model = $id;
        } else {
            $model = $this->find($id);
        }

        if (!$model) {
            return false;
        }

        if (!$model->hasRole($roles)) {
            return false;
        }

        return true;
    }
}
