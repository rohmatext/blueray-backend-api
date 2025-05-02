<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    /**
     * Scope a query to retrieve shipment statistics grouped by day.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $days  Number of days to look back for statistics
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatsByDays($query, $days = 30)
    {
        return $query->select(DB::raw('TO_CHAR(shipments.created_at, \'YYYY-MM-DD\') as date'), DB::raw('COUNT(shipments.id) as count'))
            ->where('shipments.created_at', '>=', today()->subDays($days))
            ->groupByRaw('date');
    }
}
