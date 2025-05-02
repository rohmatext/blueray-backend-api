<?php

use function Pest\Laravel\getJson;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

it('allows access to shipments', function () {
    actingAsRole('user');
    getJson('/api/shipments')->assertOk();
    getJson('/api/shipments/couriers')->assertOk();
    getJson('/api/shipments/trackings/1')->assertStatus(500);
});
