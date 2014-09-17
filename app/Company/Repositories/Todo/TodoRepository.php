<?php
namespace Company\Repositories\Todo;

use Api\Models\Todo;
use Company\Interfaces\Todo\TodoRepositoryInterface;

/**
 * Class TodoRepository
 * @package Company\Repositories\Todo
 */
class TodoRepository implements TodoRepositoryInterface
{
    /**
     * @param $todoId
     * @return mixed
     */
    public function find($todoId)
    {
        return Todo::find($todoId);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function findAllByUserId($userId)
    {
        return Todo::where('user_id', '=', $userId)->orderBy('id', 'DESC')->get();
    }
}
