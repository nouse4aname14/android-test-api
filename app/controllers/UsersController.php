<?php
namespace Api\Controllers;

use Api\Models\User;
use Company\Interfaces\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class UsersController
 * @package Api\Controllers
 */
class UsersController extends \BaseController
{

    /**
     * @var \Company\Interfaces\User\UserRepositoryInterface
     */
    protected $user;

    /**
     * @param UserRepositoryInterface $user
     */
    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }

    /**
     * Return the specified todo.
     * GET /users/{userId}
     *
     * @param  int  $userId
     * @return Response
     */
    public function show($userId)
    {
        $user = $this->user->find($userId);
        if ($user) {
            return Response::make(json_encode($user), 200);
        }

        return $this->resourceNotFound();
    }

    /**
     * Store a newly created user.
     * POST /users
     *
     * @return Response
     */
    public function store()
    {
        $input = Input::all();
        $validator = Validator::make($input, [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->email = $input['email'];
            $user->password = Hash::make($input['password']);
            $user->save();

            return Response::make(json_encode(['user_id' => $user->id]), 200);
        }

        return Response::make(json_encode(['message' => 'The inputs email, which must be a unique valid email, and password are required.']), 400);
    }
}