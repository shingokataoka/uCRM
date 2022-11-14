<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RFMService
{
    public static function rfm($subQuery, $request)
    {
        // 購買ID毎にまとめる
        $subQuery = $subQuery
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
        // ここではフォームからの各値を変数に入れている
        $rfmParams = array_merge(
            $request->rParams,
            $request->fParams,
            $request->mParams,
        );

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

        // 全顧客数を取得
        $totalCount = DB::table($subQuery)->count();

        // ランク毎の数を計算する。
        // ランクごとに数が偏りすぎるとダメなので算出して確認
        $rCount = DB::table($subQuery)
            ->rightJoin('ranks', 'r', '=', 'ranks.rank')
            ->groupBy('rank')
            ->selectRaw('r, ranks.rank, count(r) AS num')
            ->orderBy('rank', 'desc')->pluck('num');
        $fCount = DB::table($subQuery)
            ->rightJoin('ranks', 'f', '=', 'ranks.rank')
            ->groupBy('ranks.rank')
            ->selectRaw('f, ranks.rank, count(f) AS num')
            ->orderBy('ranks.rank', 'desc')->pluck('num');
        $mCount = DB::table($subQuery)
            ->rightJoin('ranks', 'm', '=', 'ranks.rank')
            ->groupBy('ranks.rank')
            ->selectRaw('m, ranks.rank, count(m) AS num')
            ->orderBy('ranks.rank', 'desc')->pluck('num');
// Log::debug($rCount);
// Log::debug($fCount);
// Log::debug($mCount);
// exit;
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

        // rとfの二次元で取得（今回はこれでいく。rfmは他の方法もある）
        $data = DB::table($subQuery)
            ->rightJoin('ranks', 'r', 'ranks.rank')
            ->groupBy('ranks.rank')
            ->selectRaw('
                CONCAT("r_", ranks.rank) AS rRank,
                COUNT(CASE WHEN f = 5 THEN 1 END) AS f_5,
                COUNT(CASE WHEN f = 4 THEN 1 END) AS f_4,
                COUNT(CASE WHEN f = 3 THEN 1 END) AS f_3,
                COUNT(CASE WHEN f = 2 THEN 1 END) AS f_2,
                COUNT(CASE WHEN f = 1 THEN 1 END) AS f_1
                ')
            ->orderBy('rRank', 'desc')->get();
        // dd($data);

        return [$data, $eachCount, $totalCount];
    }
}
