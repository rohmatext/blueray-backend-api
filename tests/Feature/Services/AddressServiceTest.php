<?php

use App\Models\Address;
use App\Models\User;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->seed();
});

function actingAsRole(string $role = 'user'): User
{
    $user = User::factory()->create([
        'password' => Hash::make('password')
    ]);
    $user->assignRole($role);
    Sanctum::actingAs($user);
    return $user;
}

it('allows user role to use address service', function () {
    $user = actingAsRole('user');
    $service = new AddressService();

    $data = [
        'name' => 'User A',
        'phone' => '08123456789',
        'address' => 'Jl. User',
        'subdistrict' => 'Sub',
        'city' => 'City',
        'province' => 'Province',
        'zip' => '12345',
        'note' => 'Catatan user',
    ];

    $address = $service->storeAddress($data);

    expect($address->user_id)->toBe($user->id);

    $fetched = $service->fetchAddressByUser();
    expect($fetched)->toHaveCount(1);

    $updated = $service->updateAddress($address, array_merge($data, ['name' => 'Updated']));
    expect($updated->name)->toBe('Updated');

    $deleted = $service->deleteAddress($address);
    expect($deleted)->toBeTrue();
});

it('allows admin role to use address service', function () {
    $admin = actingAsRole('admin');
    $service = new AddressService();

    $data = [
        'name' => 'Admin A',
        'phone' => '08987654321',
        'address' => 'Jl. Admin',
        'subdistrict' => 'AdminSub',
        'city' => 'AdminCity',
        'province' => 'AdminProvince',
        'zip' => '54321',
        'note' => 'Catatan admin',
    ];

    $address = $service->storeAddress($data);

    expect($address->user_id)->toBe($admin->id);

    $fetched = $service->fetchAddressByUser();
    expect($fetched)->toHaveCount(1);

    $updated = $service->updateAddress($address, array_merge($data, ['city' => 'Updated City']));
    expect($updated->city)->toBe('Updated City');

    $deleted = $service->deleteAddress($address);
    expect($deleted)->toBeTrue();
});
