<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Multi extends Controller
{
        public $currentStep = 1;
        public $totalSteps = 3;

        public function index()
        {
            return view('multi.multi', ['currentStep' => $this->currentStep]);
        }

        public function increaseStep()
        {
            
            if($this->currentStep == 2){
                return view('multi.multi', ['currentStep' => 3]); 
            }else{
                $this->currentStep++;
                return view('multi.multi', ['currentStep' => $this->currentStep]); 
            }
            
        }
}
