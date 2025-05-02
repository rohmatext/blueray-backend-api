<?php

namespace App\Services;

use App\Models\Shipment;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StatService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Retrieve shipment statistics for the last 30 days.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getShipmentStats()
    {
        $role = Auth::user()->roles->pluck('name')->first();
        $days = 7;

        $stats = Shipment::query()
            ->when($role === 'user', fn($query) => $query->byUser(Auth::id()))
            ->statsByDays($days)
            ->get();

        return collect(CarbonPeriod::create(Carbon::today()->subDays($days), Carbon::now()))
            ->map(fn($date) => [
                'date' => $date->format('Y-m-d'),
                'count' => $stats->where('date', $date->format('Y-m-d'))->first()->count ?? 0,
            ]);
    }

    public function getTotalShipmentStats()
    {
        $role = Auth::user()->roles->pluck('name')->first();
        return Shipment::query()
            ->select(DB::raw('COUNT(shipments.id) as count'))
            ->when($role === 'user', fn($query) => $query->byUser(Auth::id()))
            ->first();
    }
}
