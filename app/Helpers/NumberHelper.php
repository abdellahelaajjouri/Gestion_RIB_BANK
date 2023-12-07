<?php

// app/Helpers/NumberHelper.php

namespace App\Helpers;

class NumberHelper
{
    public static function convertScientificToNumber($scientific)
    {
        return floatval($scientific);
    }
}
