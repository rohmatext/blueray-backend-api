<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    public function __construct(
        private UserService $userService = new UserService()
    ) {
        //
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = $this->userService->registerNewUser($request->validated());

            DB::commit();

            return (new UserResource($user))
                ->additional([
                    'message' => __('messages.registered', ['item' => 'user']),
                ])
                ->response()
                ->setStatusCode(201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => __('messages.registration_failed'),
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
