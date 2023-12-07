<?php

namespace App\Http\Livewire;
use App\Models\Holder;
use Livewire\Component;
use App\Models\AdditionalInfo;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ParksImport;
use App\Models\InvalideCode;
use App\Models\Park;
use App\Rules\RibFormatRule;
use Illuminate\Support\Facades\Auth;



class MultiStepForm extends Component 
{
    use WithFileUploads;

    public $file ;
    public $file1;
    public $rib;
    public $raison_sociale;
    public $motif_prelev;
    public $date_envoi;
    public $nne;
    public $totalSteps = 3;
    public $currentStep = 1;
    public $parksInvalide = [];
    public $loading = false;
    public $allparks = [];
    public $selectedRais;


    public function mount(){
        $this->currentStep =1;
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
            $this->validate(
                ['file' => 'required|mimes:xlsx,csv,txt',
                'file1' => 'required|mimes:txt'],
                [
                    'file.required' => 'Ce champ est obligatoire',
                    'file1.required' => 'Ce champ est obligatoire',
                    'file.mimes' => 'Le fichier doit être de type xlsx, csv ou txt',
                    'file1.mimes' => 'Le fichier doit être de type txt'
                ],
                ['file' => 'Fichier',
                'file1' => 'Fichier du code erronées']
            );
            Park::where('userId', $userId)->delete();
            Excel::queueImport(new ParksImport, $this->file);
            $filePath = $this->file1->getRealPath();
            $fileContent = file_get_contents($filePath);
            $lines = explode(PHP_EOL, $fileContent);
            $extractedData = [];
            foreach ($lines as $line) {
                if (strpos($line, "RUMFI") === 0) {
                    continue;
                }
                if (preg_match('/fitnesspar-(\d+-\w+)/', $line, $matches)) {
                    $extractedData[] = "fitnesspar-" . $matches[1];
                }
            }
            InvalideCode::where('userId', $userId)->delete();
            foreach ($extractedData as $data) {
                InvalideCode::create(['reference_facture' => $data,'userId'=>$userId]);
            }
            $this->loading = true;
        }
        elseif($this->currentStep == 2){
            $this->validate([
                ['selectedRais' => 'required',
                'date_envoi' => 'required|date'],
                ['selectedRais.required' => 'Ce champ est obligatoire',
                'date_envoi.required' => 'Ce champ est obligatoire',],
                ['selectedRais' => 'Raison sociale',
                'date_envoi' => 'Date envoie du fichier']

            ]);
            $user = Auth::user();
            $userId = $user->id;
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
        return view('livewire.multi-step-form',compact('allInfos'));
    }


}
