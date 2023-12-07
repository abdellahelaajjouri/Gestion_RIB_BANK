<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\AdditionalInfo;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParksImport;
use App\Models\Holder;
use App\Models\Park;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class SecondMultiStepForm extends Component
{
    use WithFileUploads;

    public $loading = false;
    public $file ;
    public $rib;
    public $raison_sociale;
    public $motif_prelev;
    public $date_envoi;
    public $nne;
    public $totalSteps = 3;
    public $currentStep = 1;
    public $selectedRais;

    public function mount(){
        $this->currentStep =1  ;
    }

    public function decreaseStep(){
        $this->resetErrorBag();
        $this->currentStep--;
        if($this->currentStep < 1){
            $this->currentStep = 1;
        }
    }

    public function validateData(){
        $user = Auth::user();
        $userId = $user->id;
        if($this->currentStep == 1){

            $validatedData = $this->validate(
                ['file' => 'required|mimes:xlsx,csv,txt'],
                [
                    'file.required' => 'Ce champ est obligatoire',
                    'file.mimes' => 'Le fichier doit être de type xlsx, csv ou txt'
                ],
                ['file' => 'Fichier']
            );
            $this->loading = true;
            Park::where('userId', $userId)->delete();
            Excel::queueImport(new ParksImport, $validatedData);
            $this->file = null;
        
            
        }
        elseif($this->currentStep == 2){
            $this->loading = false;
            $user = Auth::user();
            $userId = $user->id;

            $this->validate([
                ['selectedRais' => 'required',
                'date_envoi' => 'required|date'],
                ['selectedRais.required' => 'Ce champ est obligatoire',
                'date_envoi.required' => 'Ce champ est obligatoire',],
                ['selectedRais' => 'Raison sociale',
                'date_envoi' => 'Date envoie du fichier']

            ]);
            Holder::where('userId', $userId)->delete();
            $holder = New Holder();
            $holder->userId = $userId;
            $holder->RasiId = $this->selectedRais;
            $holder->date = $this->date_envoi;
            $holder->save();
        }                                      
    }

    public function increaseStep(){
        $this->resetErrorBag();
        $this->validateData();
        $this->currentStep++;
        if($this->currentStep > $this->totalSteps){
            $this->currentStep = $this->totalSteps;
        }  
    }

    public function render()
    {
        $allInfos = AdditionalInfo::get();
        return view('livewire.second-multi-step-form',compact('allInfos'));
    }
}
