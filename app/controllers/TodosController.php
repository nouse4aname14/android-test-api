<?php

class TodosController extends \BaseController {

	/**
	 * Display a listing of the todos.
	 * GET /users/{userId}/todos
     *
	 * @param  int  $userId
	 * @return Response
	 */
	public function index($userId)
	{
        return Todo::where('user_id', '=', $userId)->get();
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
            'title' => 'required',
            'description' => 'required'
        ]);

        if (!$validator->fails()) {
            $todo = new Todo();
            $todo->user_id = $userId;
            $todo->title = $input['title'];
            $todo->description = $input['description'];
            $todo->save();
            return Response::make(json_encode($todo), 200);
        } else {
            return Response::make(json_encode(['message' => 'The inputs name and description are required.']), 400);
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
        $todo = Todo::find($todoId);
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
        $todo = Todo::find($todoId);
        if ($todo) {
            $todo->title = Input::get('title', $todo->title);
            $todo->description = Input::get('description', $todo->description);
            $todo->save();
            return Response::make(json_encode($todo), 200);
        } else {
            $this->resourceNotFound();
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
        $todo = Todo::find($todoId);
        if ($todo) {
            $todo->delete();
            return Response::make(['message' => 'Successfully deleted the todo with an id of ' . $todoId . '.'], 200);
        } else {
            return $this->resourceNotFound();
        }
	}

    public function resourceNotFound()
    {
        return Response::make(json_encode(['message' => 'Resource not found.']), 404);
    }

}