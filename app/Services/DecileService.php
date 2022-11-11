<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DecileService
{

    public static function decile($subQuery)
    {
        // 購買ID毎にまとめる
        $subQuery = $subQuery
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

        $labels = $data->pluck('decile');
        $totals = $data->pluck('totalPerGroup');

        return [$data, $labels, $totals];
    }

}
