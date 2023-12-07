<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdditionalInfo;
use App\Rules\RibFormatRule;
use Carbon\Carbon;

class crudeController extends Controller
{
 

    public function index(){
        $infos = AdditionalInfo::get();
        return view('pages.crude' , compact('infos'));
    }
    public function edit($id){
        $selectedIndexData = AdditionalInfo::where('id', $id)->first();
        return view('pages.modif' , compact('selectedIndexData'));
    }
    public function update(Request $request , $id)
    {
        $request->validate([
            'rib' => ['required', 'string', 'max:24', new RibFormatRule(24 , $request->rib)],
            'raison_sociale' => 'required|string',
            'nne' => 'required|string|max:3',
        ]);
        $organism = AdditionalInfo::find($id);
        $organism->rib = $request->rib;
        $organism->raison_sociale = $request->raison_sociale;
        $organism->nne = $request->nne;
        $organism->save();
        return redirect('/crud');
    }

    public function create(){
        return view('pages.create');
    }

    public function store(Request $request){
        $request->validate([
            'rib' => ['required', 'string', 'max:24', new RibFormatRule(24 , $request->rib)],
            'raison_sociale' => 'required|string',
            'nne' => 'required|string|max:3',
        ]);
        $organism = New AdditionalInfo();
        $organism->rib = $request->rib;
        $organism->raison_sociale = $request->raison_sociale;
        $organism->date_envoi = Carbon::now();
        $organism->nne = $request->nne;
        $organism->save();
        return redirect('/crud');
    }

    public function delete($id) 
    {
        AdditionalInfo::find($id)->delete();
        return redirect('/crud');   
    }
    
}
