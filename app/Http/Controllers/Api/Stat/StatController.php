<?php

namespace App\Http\Controllers\Api\Stat;

use App\Http\Controllers\Controller;
use App\Services\StatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatController extends Controller
{
    public function __construct(
        private StatService $statService = new StatService()
    ) {
        //
    }

    /**
     * Display a listing of the resource statistics.
     */
    public function index()
    {
        return response()->json([
            'message' => __('messages.retrieved', ['item' => 'stats']),
            'data' => [
                ...$this->statService->getTotalShipmentStats()->toArray(),
                ...(Auth::user()->roles->pluck('name')->first() === 'admin' ? [
                    'stats' => $this->statService->getShipmentStats(),
                ] : []),
            ]
        ]);
    }
}
