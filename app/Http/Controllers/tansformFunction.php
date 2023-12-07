<?php

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
        return $test_format;
    }

    $a = substr($chaine, 0, 8) % 97;
    $b = $a . substr($chaine, 8, 8);
    $ba = $b - (floor($b / 97) * 97);
    $c = $ba . substr($chaine, 16, 6) . "00";
    $d = 97 - ($c - (floor($c / 97) * 97));

    if ($d !== substr($chaine, 22, 2)) {
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



// this code defines a function named tests that iterates over a range of cells in a worksheet (appSheet). It checks various conditions for the values in these cells and assigns a specific value to the tests variable based on the conditions met. The function returns the final value of the tests variable.
// Make sure to require the PhpSpreadsheet library before using it.
// composer require phpoffice/phpspreadsheet
// Example: require 'path/to/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

function tests()
{
    $appSheet = 'Sheet1'; // Replace 'Sheet1' with your actual sheet name
    $spreadsheet = IOFactory::load('path/to/your/excel/file.xlsx'); // Replace with the path to your Excel file

    $chaine = '';
    $i = 9;
    $tests = 0;

    
    while (
        ($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue() !== '') ||
        ($spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue() !== '') ||
        ($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue() !== '')
    ) {
        $c = strlen($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue());

        if ($c !== 0 && $c !== 1 && $c !== 2) {
            $R = substr($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue(), $c - 2, 1);
            $R1 = substr($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue(), $c - 1, 1);
        }

        $t = 0;
        if (strpos($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue(), ',') !== false) {
            $t = 1;
        }

        if ($spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue() === '') {
            $tests = 2 + ($i - 8) * 11;
            return $tests;
        }

        if (gettype($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue()) === 'string') {
            $tests = 3 + ($i - 8) * 11;
            return $tests;
        } else {
            if (isset($R) && isset($R1) && $R !== ',' && $R1 !== ',' && $t === 1) {
                $tests = 4 + ($i - 8) * 11;
                return $tests;
            }
        }

        if ($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue() === '') {
            $tests = 5 + ($i - 8) * 11;
            return $tests;
        }

        if ($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue() === '') {
            $tests = 6 + ($i - 8) * 11;
            return $tests;
        }

        if ($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue() === 0) {
            $tests = 7 + ($i - 8) * 11;
            return $tests;
        }

        if ($spreadsheet->getActiveSheet()->getCell('D' . $i)->getValue() === '') {
            $tests = 8 + ($i - 8) * 11;
            return $tests;
        }

        if ($spreadsheet->getActiveSheet()->getCell('E' . $i)->getValue() === '') {
            $tests = 9 + ($i - 8) * 11;
            return $tests;
        }

        if ($spreadsheet->getActiveSheet()->getCell('F' . $i)->getValue() === '') {
            $tests = 10 + ($i - 8) * 11;
            return $tests;
        }

        $i++;
    }

    return $tests;
}

/*


The execute function processes data from an Excel file and generates a SIMT file based on the specified conditions. Here's a summary of what the function does:

It loads an Excel file using the PhpSpreadsheet library.
It fetches data from specific cells in the Excel file to set some variables used in the function.
It performs several tests and validations on the data in the Excel file to check for errors and missing values.
If any errors are found during the tests, appropriate error messages are echoed, and the function exits early.
It calculates the sum of certain cells in the Excel file until it encounters an empty cell in column A.
It sets some more variables based on the calculated sum and other values from the Excel file.
It iterates through the data again and creates the content for the DETAIL section of the SIMT file.
If the $gen_fich flag is set to 1 (indicating no errors), it creates and writes the content to the SIMT file.
In case there are errors (invalid RIBs), it populates a sheet named "ribs erronés" with the invalid RIBs.
It creates the content for the FIN section of the SIMT file and writes it to the file.
If $gen_fich is 1, it prints a success message with the generated file name.
Note: Some parts of the code contain references to functions like test_format and Complete. These functions are not present in the code you provided and may be defined elsewhere in the script or imported from external files.

Overall, the function processes data from an Excel file, checks for errors and validations, and generates a SIMT file with the appropriate content based on the input data.



*/


function execute(){
    $spreadsheet = IOFactory::load('path/to/your/excel/file.xlsx'); // Replace with the path to your Excel file

    $Code_type_enreg = "10";
    $Id_service = "00000";
    $Id_source = "VOV100";
    $Numéro_lot = "0000";

    // Replace 'VOV100' with the actual value you want to fetch from the sheet.
    $Code_participant_SIMT = $spreadsheet->getActiveSheet()->getCell('G3')->getValue();


    $Date = date('Ymd');
    $Dates = substr($Date, 0, 4) . substr($Date, 5, 2) . substr($Date, 8, 2);

    $Heure = date('His');
    $Heure = substr($Heure, 0, 2) . substr($Heure, 3, 2) . substr($Heure, 6, 2);

    $Code_devise = "MAD";
    $Nb_de_décimales_devise = "2";

    $Type_virement = "  ";

    $i = 9;
    $Somme = 0;


    $tests = 0;

    if ($spreadsheet->getActiveSheet()->getCell('A3')->getValue() === '') {
        echo "Le RIB du donneur d'ordre est Non Renseigné";
        return;
    }

    if ($spreadsheet->getActiveSheet()->getCell('G3')->getValue() === '') {
        echo "Le champ numéro Numéro National d'émetteur 'NNE' n'est pas renseigné";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 7) {
        echo "Le Montant du prélèvement Numéro " . intval($tests / 11) . " doit être différent de zéro";
        return;
    }

    if (!test_format(24, $spreadsheet->getActiveSheet()->getCell('A3')->getValue())) {
        echo "Le RIB du donneur d'ordre est mal Renseigné";
        return;
    }

    if ($spreadsheet->getActiveSheet()->getCell('B3')->getValue() === '') {
        echo "La raison sociale du donneur d'ordre est Non Renseignée";
        return;
    }

    if ($spreadsheet->getActiveSheet()->getCell('C3')->getValue() === '') {
        echo "Motif Non Renseignée";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 2) {
        echo "Le débiteur du prélèvement Numéro " . intval($tests / 11) . " est Non Renseigné";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 3) {
        echo "Le Montant du prélèvement Numéro " . intval($tests / 11) . " n'est pas numérique";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 4) {
        echo "Le Montant du prélèvement Numéro " . intval($tests / 11) . " a plus de deux chiffres aprés la virgule";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 5) {
        echo "Le Rib du prélèvement Numéro " . intval($tests / 11) . " est non renseigné";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 6) {
        echo "Le Montant du prélèvement Numéro " . intval($tests / 11) . " est non renseigné";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 8) {
        echo "La réf. du contrat prélèvement n° " . intval($tests / 11) . " est non renseignée";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 9) {
        echo "La réf. Facture du prélèvement n° " . intval($tests / 11) . " est non renseignée";
        return;
    }

    if ($tests - intval($tests / 11) * 11 === 10) {
        echo "La date d'échéance du prélèvement n° " . intval($tests / 11) . " est non renseignée";
        return;
    }

    while ($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue() !== '' && $tests === 0) {
        $Somme += round($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue(), 2);
        $i++;
    }
    
    $nbr = $i - 9; // nbr d'enregistrements
    
    if ($tests === 0) {
        $spreadsheet->getActiveSheet()->getCell('D3')->setValue($Somme);
        $spreadsheet->getActiveSheet()->getCell('E3')->setValue($nbr);
        // Replace 'Sheet2' with the actual name of the sheet where you want to update the cells
        $ribSheet = 'Sheet2';
        $spreadsheet->getSheetByName($ribSheet)->getCell('B3')->setValue($Somme);
        $spreadsheet->getSheetByName($ribSheet)->getCell('B2')->setValue($nbr);
        $spreadsheet->getSheetByName($ribSheet)->getCell('B4')->setValue($spreadsheet->getActiveSheet()->getCell('A3')->getValue());
        $spreadsheet->getSheetByName($ribSheet)->getCell('B5')->setValue(date('l'));
    }

    $Entreprise = $spreadsheet->getActiveSheet()->getCell('B3')->getValue();
    $Montant = $Somme * 100;
    $R = 9;
    $gen_fich = 1;

    while ($spreadsheet->getActiveSheet()->getCell('A' . $R)->getValue() !== '' && $tests === 0) {
        if (test_format(24, $spreadsheet->getActiveSheet()->getCell('A' . $R)->getValue())) {
            // Do nothing if the test_format condition is met.
        } else {
            $gen_fich = 0;
        }
        $R++;
    }

    $Dates = date('Ymd');
    $Nom_Fichier = __DIR__ . "\\" . substr($Entreprise, 0, 20) . "_" . $Montant . "_" . $Dates . ".txt";

    if ($gen_fich === 1) {
        $file = fopen($Nom_Fichier, "w");
        fclose($file);
    }

    if ($gen_fich === 1) {
        $Entete = $Code_type_enreg . $Id_service . $Id_source . $Numéro_lot . $Code_participant_SIMT . $Dates . $Heure . $Code_devise . $Nb_de_décimales_devise . $Type_virement;
    
        // Pad the Entete with spaces to the required length
        $Entete = str_pad($Entete, 200, ' ');
    
        // Create the text file and write the Entete to it
        $file = fopen($Nom_Fichier, "w");
        fwrite($file, $Entete . PHP_EOL);
        fclose($file);
    }

    $i = 9;
    $j = 10;
    $A1 = "04";
    $A2 = "030";
    $B1 = "021";
    $B3_1 = "780";
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
    $C13 = "                                   ";
    $C14 = "                                   ";
    $C15 = "                                   ";

    $C18 = str_pad("", 3, ' ');

    $erreurs = 1;

    while ($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue() !== "") {

        if (test_format(24, $spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue())) {
            $B2 = Complete($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue(), 3);
            $B4 = $spreadsheet->getActiveSheet()->getCell('F' . $i)->getValue() . "021000000000000000";
            $B6 = transform($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue() * 100, 16);
            $B7 = Complete($spreadsheet->getActiveSheet()->getCell('F' . $i)->getValue(), 8);
            $B8 = $spreadsheet->getActiveSheet()->getCell('F' . $i)->getValue();
            $C6 = Complete($spreadsheet->getActiveSheet()->getCell('B3')->getValue(), 35);
            $C7 = Complete($spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue(), 35);
            $B3_2 = "780";
            $C8 = Complete($spreadsheet->getActiveSheet()->getCell('A3')->getValue(), 24);
            $C9 = Complete($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue(), 24);
            $C11 = Complete($spreadsheet->getActiveSheet()->getCell('E' . $i)->getValue(), 35);
            $C12 = "                                   ";
            $C16 = "                                   ";
            $C17 = Complete($spreadsheet->getActiveSheet()->getCell('D' . $i)->getValue(), 24);
    
            $Detail = $A1 . $A2 . $B1 . $B2 . $B3_1 . $B3_2 . $B4 . $B5 . $B6 . $B7 . $B8 . $B9 . $B10 . $C1 . $C2 . $C3 . $C4 . $C5 . $C6 . $C7 . $C8 . $C9 . $C10 . $C11 . $C12 . $C13 . $C14 . $C15 . $C16 . $C17 . $C18;
    
            if ($gen_fich === 1) {
                fwrite($file, $Detail . PHP_EOL);
            }
    
        } else {
            $erreurs = 0;
    
            $spreadsheet->getSheetByName($ribSheet)->getCell('A' . $j)->setValue($spreadsheet->getActiveSheet()->getCell('A' . $i)->getValue());
            $spreadsheet->getSheetByName($ribSheet)->getCell('B' . $j)->setValue($spreadsheet->getActiveSheet()->getCell('B' . $i)->getValue());
            $spreadsheet->getSheetByName($ribSheet)->getCell('C' . $j)->setValue($spreadsheet->getActiveSheet()->getCell('C' . $i)->getValue());
            $j++;
        }
    
        $i++;
    }

    if ($erreurs === 0) {
        $spreadsheet->getSheetByName('ribs erronés')->getCell('A1')->setValue('RIBs erronés : voir la feuille ribs erronés');
    }
    
    $FA1 = "11";
    $FB1 = transform($nbr, 5);
    $FC1 = transform($Somme * 100, 20);
    $FD1 = str_pad("", 449, ' ');
    
    if ($gen_fich === 1) {
        $Fin = $FA1 . $FB1 . $FC1 . $C8 . $FD1;
        fwrite($file, $Fin . PHP_EOL);
        fclose($file);
        echo 'Le fichier SIMT généré avec succès : ' . $Nom_Fichier . PHP_EOL;
    }else{
        echo date('dm-His') . ': error ' ;
    }
    
    

}

