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

        return Inertia::render('Analysis');
    }




    // 消すの勿体無いから取っておいただけの関数
    public function decile()
    {
        $startDate = '2022-10-01';
        $endDate = '2022-11-01';

        // 購買ID毎にまとめる
        $subQuery = Order::betweenDate($startDate, $endDate)
            ->groupBy('id')
            ->selectRaw('id, customer_id, customer_name, SUM(subtotal) AS totalPerPurchase');

        // 会員毎にまとめて購入金額順にソートする
        $subQuery = DB::table($subQuery)->groupBy('customer_id')
            ->selectRaw('customer_id, customer_name, SUM(totalPerPurchase) AS total')
            ->orderBy('total', 'desc');

        // 連番のカラムを加える
        DB::statement('SET @row_num = 0;');
        $subQuery = DB::table($subQuery)
            ->selectRaw('@row_num := @row_num + 1 AS row_num, customer_id, customer_name, total');

        // 全体の件数を数え、1/10の値や金額を取得
        $count = DB::table($subQuery)->count();
        // 構成比用にトータル金額を取得
        $total = DB::table($subQuery)->selectRaw('SUM(total) AS total')->first()->total;

        $decile = (int)ceil($count / 10);

        $bindValues = [];
        $tempValue = 0;
        for ($i = 1; $i <= 10; $i++)
        {
            $bindValues[] = 1 + $tempValue;
            $tempValue += $decile;
            $bindValues[] = 1 + $tempValue;
        }
        // dump($count, $decile, $bindValues);

        DB::statement('SET @row_num = 0;');
        $subQuery = DB::table($subQuery)
            ->selectRaw('
                row_num,
                customer_id,
                customer_name,
                total,
                CASE
                    when ? <= row_num and row_num < ? then 1
                    when ? <= row_num and row_num < ? then 2
                    when ? <= row_num and row_num < ? then 3
                    when ? <= row_num and row_num < ? then 4
                    when ? <= row_num and row_num < ? then 5
                    when ? <= row_num and row_num < ? then 6
                    when ? <= row_num and row_num < ? then 7
                    when ? <= row_num and row_num < ? then 8
                    when ? <= row_num and row_num < ? then 9
                    when ? <= row_num and row_num < ? then 10
                END AS decile
            ', $bindValues);
        // dd($subQuery->get());

        // グループ毎の合計SUM()と平均AVG()を取得
        $subQuery = DB::table($subQuery)
            ->groupBy('decile')
            ->selectRaw('
                decile,
                ROUND(AVG(total)) AS average,
                SUM(total) AS totalPerGroup
            ');
        // dd($subQuery->get());

        // 構成比を取得。構成比は グループのトータル / 全体トータル * 100
        DB::statement("SET @total = {$total}");
        $data = DB::table($subQuery)
            ->selectRaw('
                decile,
                average,
                totalPerGroup,
                round(totalPerGroup / @total * 100, 1) AS totalRatio
            ')->get();
        // dd($data);

    }


    // 勿体無いから取っておいたが使わない
    public function rfm()
    {
        // 購買ID毎にまとめる
        $subQuery = Order::betweenDate($startDate, $endDate)
            ->groupBy('id')
            ->selectRaw('id, customer_id, customer_name, SUM(subtotal) AS totalPerPurchase, created_at');

        // 会員毎にまとめて、最終購入日、購入回数、合計金額を取得。
        // datediffで日付の差分、maxで日付の最新日
        $subQuery = DB::table($subQuery)
            ->groupBy('customer_id')
            ->selectRaw('
                customer_id,
                customer_name,
                MAX(created_at) AS recentDate,
                DATEDIFF(now(), MAX(created_at)) AS recency,
                COUNT(customer_id) AS frequency,
                SUM(totalPerPurchase) AS manetary
            ');

        // RFMランクの仮設定をする。プログラミングではないのでメモ見て。

        // 会員毎のRFMランクを計算
        $rfmParams = [
                14, 28, 60, 90,
                7, 5, 3, 2,
                300000, 200000, 100000, 30000,
        ];

        $subQuery = DB::table($subQuery)
            ->selectRaw('
                customer_id,
                customer_name,
                recentDate,
                recency,
                frequency,
                manetary,
                CASE
                    WHEN recency < ? THEN 5
                    WHEN recency < ? THEN 4
                    WHEN recency < ? THEN 3
                    WHEN recency < ? THEN 2
                    ELSE 1
                END AS r,
                CASE
                    WHEN ? <= frequency THEN 5
                    WHEN ? <= frequency THEN 4
                    WHEN ? <= frequency THEN 3
                    WHEN ? <= frequency THEN 2
                    ELSE 1
                END AS f,
                CASE
                    WHEN ? <= manetary THEN 5
                    WHEN ? <= manetary THEN 4
                    WHEN ? <= manetary THEN 3
                    WHEN ? <= manetary THEN 2
                    ELSE 1
                END AS m
            ', $rfmParams);
            //  dd($subQuery->get());

        // ランク毎の数を計算する。
        // ランクごとに数が偏りすぎるとダメなので算出して確認
        $totalCount = DB::table($subQuery)->count();

        $rCount = DB::table($subQuery)
            ->groupBy('r')
            ->selectRaw('r, count(r)')
            ->orderBy('r', 'desc')->pluck('count(r)');
        $fCount = DB::table($subQuery)
            ->groupBy('f')
            ->selectRaw('f, count(f)')
            ->orderBy('f', 'desc')->pluck('count(f)');
        $mCount = DB::table($subQuery)
            ->groupBy('m')
            ->selectRaw('m, count(m)')
            ->orderBy('m', 'desc')->pluck('count(m)');

        $eachCount = [];
        $rank = 5;
        for ($i = 0; $i < 5; $i++) {
            $eachCount[] = [
                'rank' => $rank,
                'r' => $rCount[$i],
                'f' => $fCount[$i],
                'm' => $mCount[$i],
            ];
            $rank--;
        }
        // dd($totalCount, $eachCount, $rCount, $fCount, $mCount);

        $data = DB::table($subQuery)
            ->groupBy('r')
            ->selectRaw('
                CONCAT("r_", r) AS rRank,
                COUNT(CASE WHEN f = 5 THEN 1 END) AS f_5,
                COUNT(CASE WHEN f = 4 THEN 1 END) AS f_4,
                COUNT(CASE WHEN f = 3 THEN 1 END) AS f_3,
                COUNT(CASE WHEN f = 2 THEN 1 END) AS f_2,
                COUNT(CASE WHEN f = 1 THEN 1 END) AS f_1
                ')
            ->orderBy('rRank', 'desc')->get();
        // dd($data);

    }
}
