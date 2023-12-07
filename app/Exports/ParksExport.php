<?php

namespace App\Exports;

use App\Models\Park;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;



class ParksExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $parks;

    public function __construct($parks)
    {
        $this->parks = $parks;
    }

    public function collection()
    {
        return $this->parks;
    }

    public function map($parks): array
    {
        return [
            $parks->rib,
            $parks->nom,
            $parks->montant,
            $parks->reference_contrat,
            $parks->reference_facture,
            $parks->date_echeance,
        ];
    }

    public function headings(): array
    {
        return [
            'RIB Débiteur',
            'Nom Débiteur',
            'Montant',
            'Référence contrat',
            'Référence facture',
            'Date décheance',
        ];
    }
    
}
