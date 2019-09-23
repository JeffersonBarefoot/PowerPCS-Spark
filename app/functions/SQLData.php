<?php

// leave namespace out so that functions are global
//namespace App\Http\Middleware;

if (!function_exists('GetPosition')) {
    /**
     * Returns a position data field
     *
     * @param integer $bytes
     * Bytes contains the size of the bytes to convert
     *
     * @param integer $decimals
     * Number of decimal places to be returned
     *
     * @return string a string in human readable format
     *
     * */
    function GetPosition($employer, $posno, $fieldname)
    {
        return = DB::table('positions')
          ->where('employer', '=', $employer)
          ->where('posno', '=', $posno)
          ->value($fieldname);

    }
}
