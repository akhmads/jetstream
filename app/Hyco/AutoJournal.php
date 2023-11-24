<?php

namespace App\Hyco;

use Illuminate\Support\Facades\DB;
use App\Models\Coa;
use App\Models\GLhd;
use App\Models\GLdt;

class AutoJournal {

    //protected static $beginning = [];

    public static function reset( $ref_id, $ref_name )
    {
        $HEADS = GLhd::where('ref_id', $ref_id)->where('ref_name', $ref_name);
        $HEAD = $HEADS->first('code');
        $code = isset($HEAD->code) ? $HEAD->code : '';
        $DT = GLdt::where('code', $code);
        $DT->delete();
        $HEADS->delete();
    }
}
