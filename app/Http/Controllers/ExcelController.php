<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ExcelController extends Controller
{

    private $filtredData;
    private $infos;

    public function __construct(ParkController $filtredData, AdditionalInfoController $infos)
    {
        $this->infos = $infos;
        $this->filtredData = $filtredData;
    }


    public function processExcel()
    {
        $Data = $this->filtredData->filterData();
        $infos = $this->infos->index();

        $parks = $Data["filterValidRibs"];

        // this code defines a function named transform that takes a number (chiffre) and a desired length (longueur) as input. The function converts the number to a string and adds leading zeros to make the string length equal to the desired length.
        function transform($chiffre, $longueur) {
            $transform = strval($chiffre);
            $n = strlen($transform);
        
            for ($i = 1; $i <= ($longueur - $n); $i++) {
                $transform = "0" . $transform;
            }
        
            return $transform;
        }

        // this code defines a function named Complete that takes a string (chaine) and a desired length (longueur) as input. The function checks if the length of the string is less than the desired length. If it is, the function appends spaces to the string until its length matches the desired length. If the string is already longer than the desired length, it extracts a substring of the desired length. The modified string is then returned as the result of the function.
        function Complete($chaine, $longueur) {
            $n = strlen($chaine);
        
            if ($n < $longueur) {
                for ($i = 1; $i <= ($longueur - $n); $i++) {
                    $chaine .= " ";
                }
            } else {
                $chaine = substr($chaine, 0, $longueur);
            }
        
            return $chaine;
        }

        // this code defines a function named test_format that performs various checks on a given string (chaine) to validate its format. It checks the length of the string, performs calculations based on specific substrings, and verifies that all characters in the string are digits. The function returns True if the string passes all the checks and False otherwise.
        function test_format($longueur, $chaine) {
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
                // echo "Modulo Check Failed: Expected $d at position 22, got " . intval(substr($chaine, 22, 2)) . PHP_EOL;
                return $test_format;
            }
        
            for ($i = 0; $i < strlen($chaine); $i++) {
                $t = is_numeric($chaine[$i]);
                if (!$t) {
                    $test_format = false;
                    // echo "Numeric Check Failed: Character at position $i is not numeric" . PHP_EOL;
                    return $test_format;
                }
            }
        
            return $test_format;
        }


        function execute($parks , $infos) {
            $nbr = count($parks); 
            $heure = date('G');
            $minute = date('i');
            $seconde = date('s');
            $Heure = sprintf('%02d%02d%02d', $heure, $minute, $seconde);
            $infos = $infos[0];
            $Code_participant_SIMT = $infos->nne;
            $Date = date('Ymd', strtotime($infos->date_envoi));
            $Dates = substr($Date, 0, 4) . substr($Date, 5, 2) . substr($Date, 8, 2);
            $Code_devise = "MAD";
            $Nb_de_décimales_devise = "2";
            $ribOrganisme = $infos->rib;
            $Type_virement = "  ";
            $Somme = 0;
            $raisSocial = $infos->raison_sociale;
            $motifPrelev = $infos->motif_prelev;
            $Entreprise = $raisSocial;
            $gen_fich = 1;
            $fileContent = "";
            $Code_type_enreg = "10";
            $Id_service = "00000";
            $Id_source = "VOV100";
            $Numéro_lot = "0000";
            $A1 = "04";
            $A2 = "030";
            $B1 = "021";
            $B3_1 = "780";
            $B3_2 = "780";
            $B5 = "MAD2";
            $B9 = "   ";
            $B10 = "                  ";
            $C1 = "00";
            $C2 = "  ";
            $C3 = "                ";
            $C4 = "                ";
            $C5 = "1";
            $C10 = "00000000";
            $C11 = "780";
            $C12 = "                                   ";
            $C16 = "                                   ";
            $C13 = "                                   ";
            $C14 = "                                   ";
            $C15 = "                                   ";
            $C18 = str_pad("", 3, ' ');
            $C8 =  Complete($ribOrganisme,24);   
            $FA1 = "11";
            $FB1 = transform($nbr, 5);
            $FC1 = transform($Somme * 100, 20);
            $FD1 = Complete("", 449);
            $Fin = $FA1 . $FB1 . $FC1 . $C8 . $FD1;
            foreach ($parks as $park) {
                $Somme += round($park->montant, 2);
            }
            $Montant = $Somme * 100;
            if ($gen_fich === 1) {
                $Entete = $Code_type_enreg . $Id_service . $Id_source . $Numéro_lot . $Code_participant_SIMT . $Dates . $Heure . $Code_devise . $Nb_de_décimales_devise . $Type_virement;
                $Entete = str_pad($Entete, 200, ' ');
                $fileContent .= $Entete . PHP_EOL;
            }
            foreach ($parks as $park) { 
                if(test_format(24, $park->rib)){
                    $B2 = substr( $park->rib, 0, 3);
                    $B4 = $park->date_echeance . "021000000000000000";
                    $B6 = transform($park->montant * 100,16);
                    $B7 = Complete($park->date_echeance,8);
                    $B8 = $park->date_echeance;
                    $C6 = Complete($raisSocial,35);
                    $C7 =  Complete($park->nom,35);
                    $C9 =  Complete($park->rib,24);
                    $C11 = Complete($park->reference_facture,35);
                    $C17= Complete($park->reference_contrat,24);
                    $Detail = $A1 . $A2 . $B1 . $B2 . $B3_1 . $B3_2 . $B4 . $B5 . $B6 . $B7 . $B8 . $B9 . $B10 . $C1 . $C2 . $C3 . $C4 . $C5 . $C6 . $C7 . $C8 . $C9 . $C10 . $C11 . $C12 . $C13 . $C14 . $C15 . $C16 . $C17 . $C18;
                    $fileContent .= $Detail . PHP_EOL;
                } 
            }
            $user = Auth::user();
            $userId = $user->id;
            if ($gen_fich === 1) {
                $fileContent .= $Fin . PHP_EOL;
                // Set headers to trigger file download
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename(substr($Entreprise, 0, 20) . "_" . $Montant . "_" . $Dates . "_" . $userId . ".txt") . '"');
                header('Content-Length: ' . strlen($fileContent));
                // Read and send the file content to the client
                echo $fileContent;
            }
        }

        execute($parks , $infos);
        return back();
        
    }

}
