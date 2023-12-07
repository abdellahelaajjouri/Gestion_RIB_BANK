<?php

namespace App\Http\Controllers;

use App\Models\AdditionalInfo;
use Illuminate\Http\Request;

class AdditionalInfoController extends Controller
{

    public function test_format($longueur, $chaine) {
        $test_format = true;
    
        if ($longueur !== strlen($chaine)) {
            $test_format = false;
            // echo "Length Check Failed: Expected length $longueur, got " . strlen($chaine) . PHP_EOL;
            return $test_format;
        }
    
        $a = intval(substr($chaine, 0, 8)) % 97;
        $b = $a . substr($chaine, 8, 8);
        $ba = intval($b) - (floor(intval($b) / 97) * 97);
        $c = $ba . substr($chaine, 16, 6) . "00";
        $d = 97 - ($c % 97);
    
        if ($d !== intval(substr($chaine, 22, 2))) {
            $test_format = false;
            return $test_format;
        }
    
        for ($i = 0; $i < strlen($chaine); $i++) {
            $t = is_numeric($chaine[$i]);
            if (!$t) {
                $test_format = false;
                return $test_format;
            }
        }
    
        return $test_format;
    }

}
