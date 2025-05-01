<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'subdistrict',
        'city',
        'province',
        'zip',
        'note',
    ];

    protected $appends = [
        'full_address',
    ];

    /**
     * The user that owns this address.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include addresses by user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $userId
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the full address as a concatenated string.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function fullAddress(): Attribute
    {
        return new Attribute(
            get: fn() => $this->address . ', Kecamatan ' . $this->subdistrict . ', Kota/Kabupaten ' . $this->city . ', Provinsi ' . $this->province . ', Kode pos ' . $this->zip,
        );
    }
}
