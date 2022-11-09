<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);

        if ($request->type === 'perDay') {
            $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y-%m-%d") AS date');

            $data = DB::table($subQuery)
                ->groupBy('date')
                ->selectRaw('date, SUM(totalPerPurchase) AS total')
                ->orderBy('date')
                ->get();

            $labels = $data->pluck('date');
            $totals = $data->pluck('total');
        }

        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' => $labels,
            'totals' => $totals,
        ], Response::HTTP_OK);
    }
}
