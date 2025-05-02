<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use function Pest\Laravel\{postJson, deleteJson, getJson, patchJson};

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

it('responds to /ping when authenticated', function () {
    actingAsRole();
    getJson('/api/ping')->assertOk()->assertJson(['message' => 'pong']);
});

it('rejects /ping when not authenticated', function () {
    getJson('/api/ping')->assertUnauthorized();
});

it('allows login and logout', function () {
    $user = User::factory()->create([
        'email' => 'testlogin@example.com',
        'password' => Hash::make('password')
    ]);

    postJson('/api/login', [
        'email' => 'testlogin@example.com',
        'password' => 'password'
    ])->assertOk();

    Sanctum::actingAs($user);
    deleteJson('/api/logout')->assertOk();
});

it('allows user to register', function () {
    postJson('/api/register', [
        'name' => 'John Doe',
        'email' => 'johnregister@example.com',
        'password' => 'password',
        'password_confirmation' => 'password'
    ])->assertCreated();
});
