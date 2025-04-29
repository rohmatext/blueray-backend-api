<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProfileController extends Controller
{
    public function __construct(
        private UserService $userService = new UserService()
    ) {
        //
    }

    /**
     * Show the profile of the authenticated user.
     */
    public function show(Request $request)
    {
        return (new UserResource($this->userService->fetchUser($request->user())))
            ->additional([
                'message' => __('messages.retrieved', ['item' => 'profile']),
            ])
            ->response()
            ->setStatusCode(200);
    }

    /**
     * Update the profile of the authenticated user.
     */
    public function update(UpdateProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $this->userService->updateUserProfile($request->user(), $request->validated());
            DB::commit();

            return (new UserResource($user))
                ->additional([
                    'message' => __('messages.updated', ['item' => 'profile']),
                ])
                ->response()
                ->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'message' => __('messages.process_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
