<?php

namespace App\Hyco;

use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\GLdt;

class Acc {

    protected static $beginning = [];
    protected static $sum = [];

    public static function beginning( $year, $code = '', $dc = '')
    {
        if( count(self::$beginning) == 0 )
        {
            $bb = DB::table('beginning_balance')
                ->where('year', $year)
                ->get();

            $beginning = [];
            $debit = $credit = 0;
            foreach( $bb as $row )
            {
                $beginning[$row->coa_code]['D'] = $row->debit;
                $beginning[$row->coa_code]['C'] = $row->credit;
                $debit = $debit + $row->debit;
                $credit = $credit + $row->credit;
            }
            $beginning['D'] = $debit;
            $beginning['C'] = $credit;

            self::$beginning = $beginning;
        }

        if( $code )
        {
            return isset(self::$beginning[$code][$dc]) ? self::$beginning[$code][$dc] : 0;
        }
        else if( $dc )
        {
            return isset(self::$beginning[$dc]) ? self::$beginning[$dc] : 0;
        }
        else
        {
            return self::$beginning;
        }
    }

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
