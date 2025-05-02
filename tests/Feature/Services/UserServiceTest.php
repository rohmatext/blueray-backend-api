<?php

use App\Enums\RolesEnum;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
    $this->service = new UserService();
});

it('registers a new user', function () {
    $data = [
        'name' => 'Test User',
        'email' => 'test12@example.com',
        'password' => 'secret123',
    ];

    $user = $this->service->registerNewUser($data);

    expect($user)->toBeInstanceOf(User::class)
        ->and(Hash::check('secret123', $user->password))->toBeTrue()
        ->and($user->hasRole(RolesEnum::USER->value))->toBeTrue()
        ->and(User::where('email', 'test12@example.com')->exists())->toBeTrue();
});

it('updates user name and email', function () {
    $user = User::factory()->create();

    $updated = $this->service->updateUser($user, [
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);

    expect($updated->name)->toBe('New Name')
        ->and($updated->email)->toBe('new@example.com');
});

it('deletes a user', function () {
    $user = User::factory()->create();

    $this->service->deleteUser($user);

    expect(User::find($user->id))->toBeNull();
});

it('updates user password', function () {
    $user = User::factory()->create();
    $newPassword = 'newpass456';

    $this->service->updateUserPassword($user, $newPassword);

    expect(Hash::check($newPassword, $user->fresh()->password))->toBeTrue();
});

it('fetches user with roles', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::USER->value);

    $fetched = $this->service->fetchUser($user);

    expect($fetched->relationLoaded('roles'))->toBeTrue();
});

it('fetches all users', function () {
    User::truncate();
    User::factory()->count(3)->create();

    $result = $this->service->fetchAllUsers();

    expect($result)->toHaveCount(3);
});
