<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AnalysisController extends Controller
{

    public function index()
    {
        $startDate = '2022-10-01';
        $endDate = '2022-10-30';

        $subQuery = Order::betweenDate($startDate, $endDate);

        $subQuery = $subQuery->where('status', true)
            ->groupBy('id')
            ->selectRaw('id, SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") AS date');

        $data = DB::table($subQuery)
            ->groupBy('date')
            ->selectRaw('date, SUM(totalPerPurchase) AS total')
            ->orderBy('date')
            ->get();

            // dd($data);

        return Inertia::render('Analysis');
    }
}
