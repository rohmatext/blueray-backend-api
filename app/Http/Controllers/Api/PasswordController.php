<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Password\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    public function __construct(
        private UserService $userService = new UserService()
    ) {
        //
    }

    /**
     * Update the password of the authenticated user.
     */
    public function update(UpdatePasswordRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->updateUserPassword($request->user(), $request->password);
            DB::commit();

            return (new UserResource($user))
                ->additional([
                    'message' => __('messages.updated', ['item' => 'password']),
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
}
