<?php
namespace Company\Interfaces\User;

/**
 * Interface UserRepositoryInterface
 * @package Company\Interfaces\User
 */
interface UserRepositoryInterface
{
    /**
     * @param $userId
     * @return mixed
     */
    public function find($userId);
}
