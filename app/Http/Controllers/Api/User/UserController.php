<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService = new UserService()
    ) {
        //
    }


    /**
     * Display a list of all users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = $request->query('search');
        $users = $this->userService->fetchAllUsers($keyword);

        return UserResource::collection($users)
            ->additional([
                'message' => __('messages.retrieved', ['item' => 'users']),
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return (new UserResource($this->userService->fetchUser($user)))
            ->additional([
                'message' => __('messages.retrieved', ['item' => 'user']),
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $updated = $this->userService->updateUser($user, $request->validated());
            DB::commit();

            return (new UserResource($updated))
                ->additional([
                    'message' => __('messages.updated', ['item' => 'user']),
                ])
                ->response()
                ->setStatusCode(200);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => __('messages.process_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        abort_if($user->id === Auth::id(), 403, __('messages.self_forbidden'));

        try {
            DB::beginTransaction();
            $deleted = $this->userService->deleteUser($user);
            DB::commit();

            if (!$deleted) {
                return response()->json([
                    'message' => __('messages.something_went_wrong'),
                ], 500);
            }

            return response()->json([
                'message' => __('messages.deleted', ['item' => 'user']),
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => __('messages.process_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
