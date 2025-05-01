<?php

namespace App\Services;

use App\Enums\RolesEnum;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Fetch all users with optional search keyword.
     *
     * @param  string|null  $search
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function fetchAllUsers(?string $search = null)
    {
        return User::with('roles')
            ->search(strlen($search) ? $search : null)
            ->latest()
            ->get();
    }

    /**
     * Fetch the given user with their roles loaded.
     *
     * @param  \App\Models\User  $user
     * @return \App\Models\User
     */
    public function fetchUser(User $user)
    {
        return $user->load('roles');
    }

    /**
     * Update the specified user's name and email.
     *
     * @param \App\Models\User $user The user to update.
     * @param array $data An array containing the user's new 'name' and 'email'.
     * @return \App\Models\User The updated user instance.
     */
    public function updateUser(User $user, array $data)
    {
        return tap($user)->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    /**
     * Delete the specified user.
     *
     * @param  \App\Models\User  $user
     * @return bool|null
     */
    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    /**
     * Registers a new user from the given request data.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public function registerNewUser(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $user->assignRole(RolesEnum::USER->value);

        return $user;
    }

    /**
     * Updates the profile information of the given user.
     *
     * @param  \App\Models\User  $user  The user whose profile is to be updated.
     * @param  array  $data  An associative array containing the new profile data.
     * @return \App\Models\User  The updated user instance.
     */

    public function updateUserProfile(User $user, array $data)
    {
        return tap($user)->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        return $user;
    }

    /**
     * Updates the password of the given user.
     *
     * @param  \App\Models\User  $user  The user whose password is to be updated.
     * @param  string  $password  The new password.
     * @return \App\Models\User  The updated user instance.
     */
    public function updateUserPassword(User $user, string $password)
    {
        return tap($user)->update([
            'password' => Hash::make($password),
        ]);
    }
}
