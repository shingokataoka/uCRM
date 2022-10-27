<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana',
        'tel',
        'email',
        'postcode',
        'address',
        'birthday',
        'gender',
        'memo',
    ];

    public function scopeSearchCustomers($query, $search)
    {
        if (empty($search)) return $query;

        // 検索処理用の$queryコピーを作成。
        // オリジナルの$queryは検索結果がなかった場合にそのまま返す用に確保
        $queryClone = clone $query;

        $queryClone
            ->where('kana', 'like', "{$search}%")
            ->orWhere('tel', 'like', "{$search}%");
        if($queryClone->exists()) return $queryClone;

        return $query;
    }
}
