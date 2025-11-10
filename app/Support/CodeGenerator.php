<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class CodeGenerator
{
    public static function next(string $prefix, string $table, string $column = 'reference_no', int $pad = 4): string
    {
        $year = now()->format('Y');
        $base = $prefix . $year . '-';
        $last = DB::table($table)->where($column, 'like', $base . '%')
            ->orderBy($column, 'desc')->value($column);
        $seq = $last ? ((int)substr($last, strlen($base))) + 1 : 1;
        return $base . str_pad((string)$seq, $pad, '0', STR_PAD_LEFT);
    }

    public static function nextProductCode(int $pad = 4): string
    {
        $base = 'PRD';
        $table = 'products';
        $column = 'product_code';
        $last = DB::table($table)->where($column, 'like', $base . '%')
            ->orderBy($column, 'desc')->value($column);
        $seq = $last ? (int)substr($last, strlen($base)) + 1 : 1;
        return $base . str_pad((string)$seq, $pad, '0', STR_PAD_LEFT);
    }
}
