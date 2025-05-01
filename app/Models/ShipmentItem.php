<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipmentItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shipment_id',
        'name',
        'description',
        'category',
        'sku',
        'value',
        'quantity',
        'length',
        'width',
        'height',
        'weight',
    ];

    /**
     * The shipment that this shipment item belongs to.
     *
     * @return BelongsTo
     */
    public function shipment(): BelongsTo
    {
        return $this->belongsTo(Shipment::class);
    }
}
