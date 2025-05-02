<?php

use function Pest\Laravel\getJson;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

it('allows user and admin to access addresses', function () {
    actingAsRole('user');
    getJson('/api/addresses')->assertOk();
    getJson('/api/addresses/provinces')->assertOk();
});
