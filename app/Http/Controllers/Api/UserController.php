<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user =  new UserResource(User::create($request->all('email', 'name', 'user_name')));
        return $this->successfulResponse('User has been created');
    }   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => ['sometimes', Rule::unique('users', 'user_name')->ignore($user->id)]
        ]);

        if ($validator->fails()) {
          return $this->failedResponse($validator->errors()->first(), $validator->errors());
        }

        $user->update($request->all());
        return $this->successfulResponse('User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $userName = $user->user_name;
        $user->delete();
        return $this->successfulResponse('User has been deleted');

    }

    protected function successfulResponse($message, $error = 'Success') {
        return response()->json([
            'message' => $message,
            'status' => $error,
        ], 200);
    }

    protected function failedResponse($message, $error = 'Failed') {
        return response()->json([
            'message' => $message,
            'errors' => $error,
        ], 422);
    }
}
