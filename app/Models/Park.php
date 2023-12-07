<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Park extends Model   
{
    use HasFactory;

    protected $fillable = [
        'rib',
        'nom',
        'montant',
        'reference_contrat',
        'reference_facture',
        'date_echeance',
        'userId'
    ];
    

    public static function test_format($longueur, $rib)
    {
        $test_format = true;

        if ($longueur !== strlen($rib)) {
            $test_format = false;
            return $test_format;
        }

        return $test_format;
    }

    public static function cdm_check($rib)
    {
        if (substr($rib, 0, 3) == "021") {
            return true;
        }
        return false;
    } 
    
    
    public static function nameCheck($inputString){
        $allowedCharacters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
    
        for ($i = 0; $i < strlen($inputString); $i++) {
            if (strpos($allowedCharacters, $inputString[$i]) === false) {
                return false;
            }
        }
        
        return true;
    }


    public static function montantCheck($montant) {
        if (!empty($montant) && $montant != 0) {
            $decimalPart = abs($montant - floor($montant));
            if ($decimalPart < 0.01) { 
                return true;
            }
        }
        return false; 
    }


    
    public static function notEmpty($value){
        if(!empty($value)){
            return true;
        }
        return false;
    }


}
