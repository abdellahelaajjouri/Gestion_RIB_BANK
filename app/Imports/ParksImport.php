<?php

namespace App\Imports;

use App\Models\Park;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;


class ParksImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */   
    
     
    public $rowId = 0;

    public function model(array $row)
    {

        
        if(isset($row['iban'])){
            $user = Auth::user();
            $userId = $user->id;
    
            if (isset($row['iban'])) {
                $rib = $row['iban'];
            }
            
            if(isset($row['nom']) && isset($row['prnom'])) {
                $nom = $row['nom'].' '.$row['prnom'];
            }
    
            if (isset($row['montant_ligne_lot_de_prlvement'])) {
                $montant = $row['montant_ligne_lot_de_prlvement'];
            }
    
            if(isset($row['rum'])){
                $reference_contrat = $row['rum'];
            }
    
            if(isset($row['rfrence_ligne_lot_de_prlvement'])) {
                $reference_facture = $row['rfrence_ligne_lot_de_prlvement'];
            }
    
            if(isset($row['date_ligne_lot_de_prlvement'])) {
                if (Carbon::hasFormat($row['date_ligne_lot_de_prlvement'], 'd/m/Y')) {
                    $date_echeance = Carbon::createFromFormat('d/m/Y', $row['date_ligne_lot_de_prlvement'])->format('Ymd');
                }else{
                    $date_echeance = $row['date_ligne_lot_de_prlvement'];
                }
            }
    
    
    
            $park = new Park();
            $park->rib = $rib;
            $park->nom = $nom;
            $park->montant = (double)$montant;
            $park->reference_contrat = $reference_contrat;
            $park->reference_facture = $reference_facture;
            $park->date_echeance = $date_echeance;
            $park->userId = $userId;
            $park->save();
            return $park;
        }
        if($this->rowId == 0 && isset( $row['column1']) && $row['column1'] == "RIB du bénéficiaire" ){
            $this->rowId += 1;
        }
        elseif($this->rowId == 1 && isset( $row['column4']) &&  is_numeric($row['column4'])){
            $this->rowId += 1;
        }
        elseif($this->rowId== 2 && isset( $row['column1'])  && $row['column1'] == 'RIB du débiteur'){
            $this->rowId += 1;
        }elseif($this->rowId == 3){
            $user = Auth::user();
            $userId = $user->id;
            $park = new Park();
            if(isset($row['column1'])){
                $rib = $row['column1'];
            }
            if(isset($row['column2'])){
                $nom = $row['column2'];
            }
            if(isset($row['column3'])){
                $montant = $row['column3'];
            }
            if(isset($row['column4'])){
                $reference_contrat = $row['column4'];
            }
            if(isset($row['column5'])){
                $reference_facture = $row['column5'];
            }
            if(isset($row['column6'])){
                if (Carbon::hasFormat($row['column6'], 'd/m/Y')){
                    $date_echeance = Carbon::createFromFormat('d/m/Y', $row['column6'])->format('Ymd');
                }else{
                    $date_echeance = $row['column6'];
                }
            }
            $park->rib = $rib;
            $park->nom = $nom;
            $park->montant = $montant;
            $park->reference_contrat = $reference_contrat;
            $park->reference_facture = $reference_facture;
            $park->date_echeance = $date_echeance;
            $park->date_echeance = $date_echeance;
            $park->userId = $userId;
            $park->save();
            return $park;
        }


        
    }

    /**
        * @return int
    */

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 200000;
    }
}
