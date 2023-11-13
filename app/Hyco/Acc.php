<?php

namespace App\Hyco;

use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\GLdt;

class Acc {

    protected static $sum = [];

    public static function sum( $code = '', $dc = '' )
    {
        if( count(self::$sum) == 0 )
        {
            $gldt = DB::table('gldt')
                ->select(DB::raw(" coa_code, SUM(debit) as total_debit, SUM(credit) as total_credit "))
                ->groupBy('coa_code')
                ->get();

            $sum = [];
            $debit = $credit = 0;
            foreach( $gldt as $row )
            {
                $sum[$row->coa_code]['D'] = $row->total_debit;
                $sum[$row->coa_code]['C'] = $row->total_credit;
                $debit = $debit + $row->total_debit;
                $credit = $credit + $row->total_credit;
            }
            $sum['D'] = $debit;
            $sum['C'] = $credit;

            self::$sum = $sum;
        }

        if( $code )
        {
            return isset(self::$sum[$code][$dc]) ? self::$sum[$code][$dc] : 0;
        }
        else if( $dc )
        {
            return isset(self::$sum[$dc]) ? self::$sum[$dc] : 0;
        }
        else
        {
            return self::$sum;
        }
    }

    public static function sumh( $code )
    {
        $sum = DB::table('gldt')
                ->select(DB::raw(" SUM(debit) as total_debit, SUM(credit) as total_credit "))
                ->where('coa_code', 'like', $code . '%')
                ->get()->first();
        print_r($sum);
    }

    public static function reset()
    {
        self::$sum = [];
    }
}
