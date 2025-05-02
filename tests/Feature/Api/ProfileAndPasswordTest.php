<?php

use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});


it('shows and updates profile', function () {
    actingAsRole();

    getJson('/api/profile')->assertOk();

    patchJson('/api/profile', [
        'name' => 'Updated Name',
        'email' => 'updated@example'
    ])->assertOk();
});

it('updates password', function () {
    actingAsRole();

    patchJson('/api/password', [
        'current_password' => 'password',
        'password' => 'newpassword',
        'password_confirmation' => 'newpassword'
    ])->assertOk();
});
