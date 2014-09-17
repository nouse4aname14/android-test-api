<?php
namespace Company\Interfaces\Todo;

/**
 * Interface TodoRepositoryInterface
 * @package Company\Interfaces\Todo
 */
interface TodoRepositoryInterface
{
    /**
     * @param $todoId
     * @return mixed
     */
    public function find($todoId);

    /**
     * @param $userId
     * @return mixed
     */
    public function findAllByUserId($userId);
}
