<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'external_id',
        'status',
        'courier_company',
        'courier_type',
        'courier_link',
        'tracking_id',
        'delivery_type',
        'delivery_datetime',
        'price',
        'shipper_name',
        'origin_name',
        'origin_phone',
        'origin_address',
        'destination_name',
        'destination_phone',
        'destination_address',
        'reference_id',
        'raw_response',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'delivery_datetime' => 'datetime',
            'raw_response' => 'json',
        ];
    }

    /**
     * Get the user that owns the shipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items associated with the shipment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(ShipmentItem::class);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
