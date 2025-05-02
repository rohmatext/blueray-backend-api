<?php

use App\Enums\RolesEnum;
use App\Models\User;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\patchJson;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

it('allows admin to manage users', function () {
    $admin = actingAsRole('admin');

    getJson('/api/users')->assertOk();
    $target = User::factory()->create()->assignRole(RolesEnum::USER->value);

    getJson("/api/users/{$target->id}")->assertOk();

    patchJson("/api/users/{$target->id}", [
        'email' => 'updated@example',
        'name' => 'New Name'
    ])->assertOk();

    deleteJson("/api/users/{$target->id}")->assertOk();
});
