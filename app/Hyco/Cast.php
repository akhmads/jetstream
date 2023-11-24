<?php

namespace App\Hyco;

class Cast {

    public static function number( $num )
    {
        if(empty($num)) return 0;
        $num = @trim(@rtrim(@ltrim($num)));
        return preg_replace('#[^0-9\.]#i', '', $num);
    }

    public static function currency( $num, $decimal = 2 )
    {
        if(empty($num)) return 0;
        $num = @trim(@rtrim(@ltrim($num)));
        $num = preg_replace('#[^0-9\.]#i', '', $num);
        return number_format($num, $decimal, '.', '');
    }
}
