<?php

namespace App\HelperClasses\Traits;

trait NepalitoEnglish
{

   public function nepali_to_english($number)
    {
        $en_number = array(
            "0",
            "1",
            "2",
            "3",
            "4",
            "5",
            "6",
            "7",
            "8",
            "9"
        );
        $np_number = array(
            "०",
            "१",
            "२",
            "३",
            "४",
            "५",
            "६",
            "७",
            "८",
            "९"
        );
        return str_replace( $np_number,$en_number, $number);
    }

}
