<?php

class UsersController extends \BaseController {

    /**
     * Return the specified todo.
     * GET /users/{userId}
     *
     * @param  int  $userId
     * @return Response
     */
    public function show($userId)
    {
        $user = User::find($userId);
        if ($user) {
            return Response::make(json_encode($user), 200);
        } else {
            return $this->resourceNotFound();
        }
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
            if (Auth::attempt(['email' => $input['email'], 'password' => $input['password']]))
            {
                $authToken = AuthToken::create(Auth::user());
                $publicToken = AuthToken::publicToken($authToken);
                return Response::make(json_encode(['user_id' => $user->id, 'auth_token' => $publicToken]), 200);
            }

        } else {
            return Response::make(json_encode(['message' => 'The inputs email, which must be a unique valid email, and password are required.']), 400);
        }
    }
}