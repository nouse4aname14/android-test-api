<?php
namespace Api\Controllers;

use Api\Models\Todo;
use Company\Interfaces\Todo\TodoRepositoryInterface;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class TodosController
 * @package Api\Controllers
 */
class TodosController extends \BaseController
{

    /**
     * @var \Company\Interfaces\Todo\TodoRepositoryInterface
     */
    protected $todo;

    /**
     * Inject the TodoRepositoryInterface for SOLID goodness.
     *
     * @param TodoRepositoryInterface $todo
     */
    public function __construct(TodoRepositoryInterface $todo)
    {
        $this->todo = $todo;
    }

	/**
	 * Display a listing of the todos.
	 * GET /users/{userId}/todos
     *
	 * @param  int  $userId
	 * @return Response
	 */
	public function index($userId)
	{
        return $this->todo->findAllByUserId($userId);
	}

	/**
	 * Store a newly created todo.
	 * POST /users/{userId}/todos
	 *
     * @param  int  $userId
	 * @return Response
	 */
	public function store($userId)
	{
        $input = Input::all();
        $validator = Validator::make($input, [
            'title' => 'required'
        ]);

        $description = isset($input['description']) ? $input['description'] : '';

        if (!$validator->fails()) {
            $todo = new Todo();
            $todo->user_id = $userId;
            $todo->title = $input['title'];
            $todo->description = $description;
            $todo->save();
            return Response::make(json_encode($todo), 200);
        } else {
            return Response::make(json_encode(['message' => 'The input title is required.']), 400);
        }
	}

	/**
	 * Return the specified todo.
	 * GET /users/{userId}/todos/{todoId}
	 *
	 * @param  int  $userId
     * @param  int  $todoId
	 * @return Response
	 */
	public function show($userId, $todoId)
	{
        $todo = $this->todo->find($todoId);
        if ($todo) {
            return Response::make(json_encode($todo), 200);
        } else {
            return $this->resourceNotFound();
        }
	}

	/**
	 * Update the specified todo.
	 * PUT /users/{userId}/todos/{todoId}
	 *
     * @param  int  $userId
     * @param  int  $todoId
	 * @return Response
	 */
	public function update($userId, $todoId)
	{
        $todo = $this->todo->find($todoId);
        if ($todo) {
            $todo->title = Input::get('title', $todo->title);
            $todo->description = Input::get('description', $todo->description);
            $todo->save();
            return Response::make(json_encode($todo), 200);
        } else {
            return $this->resourceNotFound();
        }
	}

	/**
	 * Remove the specified todo.
	 * DELETE /users/{userId}/todos/{todoId}
	 *
     * @param  int  $userId
     * @param  int  $todoId
	 * @return Response
	 */
	public function destroy($userId, $todoId)
	{
        $todo = $this->todo->find($todoId);
        if ($todo) {
            $todo->delete();
            return Response::make(['message' => 'Successfully deleted the todo with an id of ' . $todoId . '.'], 200);
        } else {
            return $this->resourceNotFound();
        }
	}

    /**
     * Create a resource not found message.
     *
     * @return Response
     */
    public function resourceNotFound()
    {
        return Response::make(json_encode(['message' => 'Resource not found.']), 404);
    }
}
