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
        return $this->createdResponse($user);
    }   

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        if($user->is_blocked) {
            return $this->userIsBlockedResponse();
        }
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
        if($user->is_blocked) {
            return $this->userIsBlockedResponse();
        }

        $validator = Validator::make($request->all(), [
            'user_name' => Rule::unique('users', 'user_name')->ignore($user->id),
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        $user->update($request->all('user_name', 'name'));
        return $this->successfulResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->is_blocked) {
            return $this->userIsBlockedResponse();
        }

        $userName = $user->user_name;
        $user->delete();
        return $this->deletedResponse($userName);

    }

    protected function userIsBlockedResponse() {
        return response()->json([
            'message' => 'User is blocked',
            'error' => 'The resource is forbidden',
        ], 403);
    }

    protected function successfulResponse() {
        return response()->json([
            'message' => 'User has been updated',
            'status' => 'Success',
        ], 200);
    }

    protected function createdResponse(UserResource $user) {
        return response()->json([
            'message' => 'User has been created',
            'status' => 'Success',
            'user' => $user
        ], 200);
    }
    protected function deletedResponse(string $userName) {
        return response()->json([
            'message' => 'User "' . $userName . '" has been deleted',
            'status' => 'Success'
        ], 200);
    }
}
