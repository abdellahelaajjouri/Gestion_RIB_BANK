<?php

namespace App\Http\Controllers;

use App\Exports\ParksExport;
use App\Imports\ParksImport;
use App\Models\AdditionalInfo;
use App\Models\Holder;
use App\Models\InvalideCode;
use App\Models\Park;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;    
use Illuminate\Support\Collection;


class ParkController extends Controller
{

    // ! execute functions 
    public  function transform($chiffre, $longueur)
    {
        $transform = strval($chiffre);
        $n = strlen($transform);

        for ($i = 1; $i <= ($longueur - $n); $i++) {
            $transform = "0" . $transform;
        }

        return $transform;
    }
    
    public  function Complete($chaine, $longueur)
    {
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
    public function test_format($longueur, $chaine)
    {
        $test_format = true;

        if ($longueur !== strlen($chaine)) {
            $test_format = false;
            return $test_format;
        }

        $a = intval(substr($chaine, 0, 8)) % 97;
        $b = $a . substr($chaine, 8, 8);
        $ba = intval($b) - (floor(intval($b) / 97) * 97);
        $c = $ba . substr($chaine, 16, 6) . "00";
        $d = 97 - ((int)$c % 97);

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
    public function execute($parks, $infos , $type)
    {
        $date_envoi = date('Ymd', strtotime($infos->date_envoi));
        $heure = date('G');
        $minute = date('i');
        $seconde = date('s');
        $Heure = sprintf('%02d%02d%02d', $heure, $minute, $seconde);
        $Date = date('Ymd', strtotime($date_envoi));
        $Code_participant_SIMT = $infos->nne;
        $Code_devise = "MAD";
        $Nb_de_décimales_devise = "2";
        $ribOrganisme = $infos->rib;
        $Type_virement = "  ";
        $raisSocial = $infos->raison_sociale;
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
        $C8 =  $this->Complete($ribOrganisme, 24);
        $FA1 = "11";

        if ($gen_fich === 1) {
            $Entete = $Code_type_enreg . $Id_service . $Id_source . $Numéro_lot . $Code_participant_SIMT . $Date . $Heure . $Code_devise . $Nb_de_décimales_devise . $Type_virement;
            $Entete = str_pad($Entete, 200, ' ');
            $fileContent .= $Entete . PHP_EOL;
        }
        $validRibs = [];
        $montantSum = 0;
        foreach ($parks as $park) {
            if ($this->test_format(24, $park->rib)) {
                $B2 = substr($park->rib, 0, 3);
                $B4 = $date_envoi . "021000000000000000";
                $B6 = $this->transform($park->montant * 100, 16);
                $B7 = $this->Complete($date_envoi, 8);
                $B8 = $date_envoi;
                $C6 = $this->Complete($raisSocial, 35);
                $C7 =  $this->Complete($park->nom, 35);
                $C9 =  $this->Complete($park->rib, 24);
                $C11 = $this->Complete($park->reference_facture, 35);
                $C17 = $this->Complete($park->reference_contrat, 24);
                $Detail = $A1 . $A2 . $B1 . $B2 . $B3_1 . $B3_2 . $B4 . $B5 .$B6. $B7 . $B8 . $B9 . $B10 . $C1 . $C2 . $C3 . $C4 . $C5 . $C6 . $C7 . $C8 . $C9 . $C10 . $C11 . $C12 . $C13 . $C14 . $C15 . $C16 . $C17 . $C18;
                $montantSum += $park->montant * 100;
                $fileContent .= $Detail . PHP_EOL;
                $validRibs[]  = $park;
            }
        }
        $FB1 = $this->transform(count($validRibs), 5);
        $FC1 = $this->transform($montantSum, 20);
        $FD1 = $this->Complete("", 449);
        $Fin = $FA1 . $FB1 . $FC1 . $C8 . $FD1;
     
        
        if ($gen_fich === 1) {
            $fileContent .= $Fin . PHP_EOL;
            header('Content-Type: application/octet-stream');   
            if($type == 'cdm'){
                header('Content-Disposition: attachment; filename="' . basename(substr($Entreprise, 0, 20) . "_" . $montantSum . "_" . $Date . "_CDM" .".txt") . '"');
            } else{
                header('Content-Disposition: attachment; filename="' . basename(substr($Entreprise, 0, 20) . "_" . $montantSum . "_" . $Date . "_CONF" .".txt") . '"');
            }
            header('Content-Length: ' . strlen($fileContent));
            echo $fileContent;
        }
    }


    // ! exports 
    public function ExportWithoutInvalideCodes(Request $request, $type)
    {
        $user = Auth::user();
        $userId = $user->id;
        $factures = InvalideCode::where('userId',$userId)->pluck('reference_facture')->toArray();
        $parksXXX = collect(Park::where('userId',$userId)->get());
        function customWhereNotIn(Collection $collection, $property, $values)
        {
            return $collection->reject(function ($item) use ($property, $values) {
                return in_array($item->{$property}, $values);
            });
        }
        $filteredArray = customWhereNotIn($parksXXX, 'reference_facture', $factures);
        $filteredCdm = [];
        $filteredAutre = [];
        $filterRibError = [];
        $filterValidRibs = [];
        $filterSpecialCharachter = [];
        foreach ($filteredArray as $park) {
            $cdm = Park::cdm_check($park->rib);
            $valid = Park::test_format(24, $park->rib);
            $montantValid = Park::montantCheck($park->montant);
            $originalPark = clone $park;

            if (!Park::nameCheck($park->nom)) {
                $filterSpecialCharachter[] = $originalPark; 
            }
            if ($valid &&   $montantValid && $cdm == true ) {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filteredData[] = $park;
            } else if ($valid  && $montantValid && $cdm == false  ) {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filteredAutre[] = $park;
            }
            if (!$valid) {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filterRibError[] = $park;
            } else {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filterValidRibs[] = $park;
            }
        }
        $holder = Holder::where('userId', $userId)->first();
        $_infos = AdditionalInfo::where('id', $holder->RasiId)->first();
        $user = Auth::user();
        $userName = $user->name;
        switch ($type) {
            case 'cdm':
                $this->execute($filteredCdm, $_infos , "cdm");
                break;

            case 'autre':
                $this->execute($filteredAutre, $_infos , "");
                break;

            case 'ribsEr':
                return  Excel::download(new ParksExport(collect($filterRibError)), ('rib-erronés' . $userName . '.xls'), \Maatwebsite\Excel\Excel::XLS);
                break;

            case 'fNames':
                return  Excel::download(new ParksExport(collect($filterSpecialCharachter)), ('noms-erronés' . $userName . '.xls'), \Maatwebsite\Excel\Excel::XLS);
                break;
        }
    }

    public function Export($type)
    {
        $user = Auth::user();
        $userId = $user->id;
        $user = Auth::user();
        $userId = $user->id;
        $parks = Park::where('userId', $userId)->get();
        $filteredData = [];
        $filteredAutre = [];
        $filterRibError = [];
        $filterValidRibs = [];
        $filterSpecialCharachter = [];
        foreach ($parks as $park) {
            $cdm = Park::cdm_check($park->rib);
            $valid = Park::test_format(24, $park->rib);
            $montantValid = Park::montantCheck($park->montant);
            $originalPark = clone $park;

            if (!Park::nameCheck($park->nom)) {
                $filterSpecialCharachter[] = $originalPark; 
            }

            if ($valid &&   $montantValid && $cdm == true ) {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filteredData[] = $park;
            } else if ($valid  && $montantValid && $cdm == false  ) {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filteredAutre[] = $park;
            }
            if (!$valid) {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filterRibError[] = $park;
            } else {
                if (!Park::nameCheck($park->nom)) {
                    $park->nom = $this->correctFrenchCharacters($park->nom);
                }
                $filterValidRibs[] = $park;
            }
            
        }
        $holder = Holder::where('userId', $userId)->first();
        $_infos = AdditionalInfo::where('id', $holder->RasiId)->first();
        $user = Auth::user();
        $userName = $user->name;
        switch ($type) {
            case 'cdm':
                $this->execute($filteredData, $_infos , "cdm");
                break;
            case 'autre':
                $this->execute($filteredAutre, $_infos , "");
                break;
            case 'ribsEr':
                return  Excel::download(new ParksExport(collect($filterRibError)), ('rib-erronés' . $userName . '.xls'), \Maatwebsite\Excel\Excel::XLS);
                break;
            case 'fNames':
                return  Excel::download(new ParksExport(collect($filterSpecialCharachter)), ('noms-erronés' . $userName . '.xls'), \Maatwebsite\Excel\Excel::XLS);
                break;
        }
    }


    // ! Util 

    public function correctFrenchCharacters($inputString)
    {
        $replacement = array(
            'É' => 'e', 'é' => 'e',
            'È' => 'e', 'è' => 'e',
            'À' => 'a', 'à' => 'a',
            'Â' => 'a', 'â' => 'a',
            'Ê' => 'e', 'ê' => 'e',
            'Î' => 'i', 'î' => 'i',
            'Ô' => 'o', 'ô' => 'o',
            'Û' => 'u', 'û' => 'u',
            'Ë' => 'e', 'ë' => 'e',
            'Ï' => 'i', 'ï' => 'i',
            'Ü' => 'u', 'ü' => 'u',
            'Ç' => 'c', 'ç' => 'c'
        );

        $outputString = '';

        for ($i = 0; $i < mb_strlen($inputString); $i++) {
            $char = mb_substr($inputString, $i, 1);

            if (isset($replacement[$char])) {
                $outputString .= $replacement[$char];
            } elseif (preg_match('/[a-zA-Z]/', $char) || $char = " ") {
                $outputString .= $char;
            }
        }

        return $outputString;
    }

}
