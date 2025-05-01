<?php

namespace App\Enums;

enum ShipmentStatusEnum: string
{
    case Confirmed = 'confirmed';
    case Allocated = 'allocated';
    case PickingUp = 'pickingUp';
    case Picked = 'picked';
    case DroppingOff = 'droppingOff';
    case ReturnInTransit = 'returnInTransit';
    case OnHold = 'onHold';
    case Delivered = 'delivered';
    case Rejected = 'rejected';
    case CourierNotFound = 'courierNotFound';
    case Returned = 'returned';
    case Cancelled = 'cancelled';
    case Disposed = 'disposed';
}
