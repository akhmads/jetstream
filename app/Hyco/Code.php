<?php

namespace App\Hyco;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Code as TCode;
use App\Models\ResCode;

class Code {

    public static function get( $resource ): string
    {
        $row = ResCode::where('resource', $resource)->first();
        return $row->code ?? '';
    }

    public static function auto( $date, $resource ): string
    {
        $code = self::get($resource);
        $time = strtotime($date);
        $prefix = $code.'/'.date('y',$time).'/'.date('m',$time).'/';
        TCode::updateOrCreate(
            ['prefix' => $prefix],
        )->increment('num');
        $code = TCode::where('prefix', $prefix)->first();
        return $code->prefix . Str::padLeft($code->num, 4, '0');
    }
}
