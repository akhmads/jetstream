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

    public static function list( $resource ): array
    {
        $row = ResCode::where('resource', $resource)->first();
        $codes = empty($row->code) ? [] : explode(',',$row->code);
        $result = [];
        foreach( $codes as $code ){
            $result[$code] = trim($code);
        }
        return $result;
    }

    public static function make( $date, $code ): string
    {
        $time = strtotime($date);
        $prefix = $code.'/'.date('y',$time).'/'.date('m',$time).'/';
        TCode::updateOrCreate(
            ['prefix' => $prefix],
        )->increment('num');
        $code = TCode::where('prefix', $prefix)->first();
        return $code->prefix . Str::padLeft($code->num, 4, '0');
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
