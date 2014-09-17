<?php
namespace Company\Repositories\User;

use Api\Models\User;
use Company\Interfaces\User\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package Company\Repositories\User
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * @param $userId
     * @return mixed
     */
    public function find($userId)
    {
        return User::find($userId);
    }
}
