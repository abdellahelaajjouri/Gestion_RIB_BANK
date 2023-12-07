<x-app-layout class="bg-white ">
    <x-slot name="header" class="h-full">
        <div>
            {{-- <div id="loading" class="loading">Loading&#8230;</div>
            @if($loading)
                <script>
                    document.getElementById('loading').style.display = 'block';
                </script>
            @else
                <script>
                    function loadingData() {
                        document.getElementById('loading').style.display = 'none';
                    }   
                </script>
            @endif --}}
            
            @if($currentStep == 1)
                <div class=" items-center  w-full  flex-col flex justify-center">
                    <div class="text-black-1000">
                        Etape 1/3 - importer fichier  
                    </div>  
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                                Choisir un fichier:
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="file" id="file" type="file" >
                            @error('file')
                                    <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                    <div class="flex justify-between bg-white pt-2 pb-2">
                        {{-- @if($currentStep == 1) --}}
                        <div></div>
                        {{-- @endif --}}
            
                        {{-- @if($currentStep == 2 || $currentStep == 3) --}}
                        {{-- <button type="button" class="btn btn-md btn-secondary" wire:click="decreaseStep()">Retour</button> --}}
                        {{-- @endif --}}
            
                        {{-- @if($currentStep == 1 || $currentStep == 2) --}}
                        {{-- wire:click="increaseStep()" onclick="loadingData()" --}}
                        <form action="{{ route('increaseStep')}}" method="GET">
                            <button type="submit" class="btn btn-md btn-success">Suivant</button>
                        </form>
                        {{-- @endif --}}
        
                    </div>
                </div>
            @endif
        
        
            @if($currentStep == 2)
                <div class="items-center  w-full  flex-col flex justify-center">
                    <div class="text-black-1000">
                        Etape 2/3 - Remplissez les détails
                    </div>  
                    <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <div class="mb_4">
        
                            <select id="selectedRais" name="selectedRais" class="bg-white border text-black-900 text-sm rounded-lg  block w-full p-2.5   focus:ring-blue-500 focus:border-blue-500 mb-2" wire:model="selectedRais">
                                <option selected value="">Choisir votre Raison sociale de l’organisme</option>
                                {{-- @foreach ($allInfos as $info)
                                    <option value="{{$info->id}}">{{$info->raison_sociale}}</option>
                                @endforeach --}}
                            </select>
                            @error('selectedRais')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
        
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="date_envoi">
                                Date envoie du fichier :
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="date_envoi" id="date_envoi" type="date" value="{{ $firstRow->date_envoi ?? '' }}" wire:model="date_envoi" min="{{ date('Y-m-d') }}">
        
                            @error('date_envoi')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
        
                    </form> 
                    <div class="flex justify-between bg-white pt-2 pb-2">
                        {{-- @if($currentStep == 1) --}}
                        {{-- <div></div> --}}
                        {{-- @endif --}}
            
                        {{-- @if($currentStep == 2 || $currentStep == 3) --}}
                        <button type="button" class="btn btn-md btn-secondary mx-7" wire:click="decreaseStep()">Retour</button>
                        {{-- @endif --}}
            
                        {{-- @if($currentStep == 1 || $currentStep == 2) --}}
                        <form action="{{ route('increaseStep')}}" method="GET">
                            <button type="submit" class="btn btn-md btn-success">Suivant</button>
                        </form>
                        {{-- @endif --}}
        
                    </div>
                </div>
            @endif
        
            @if($currentStep == 3)
                <div class="items-center  w-full  flex-col flex justify-center">
                    <div class="text-black-1000">
                    Etape 3/3 - Exporter fichier
                    </div>  
                    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                        <form action="{{ route('processExport',['type' => 'cdm']) }}" method="POST">
                            @csrf
                            <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                Crédit du Maroc
                            </button>
                        </form>
                        <form action="{{ route('processExport',['type' => 'autre']) }}" method="POST">
                            @csrf
                            <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                Autres Banques
                            </button>
                        </form>
                        <form action="{{ route('processExport',['type' => 'ribsEr']) }}" method="POST">
                            @csrf
                            <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                Rib erronés
                            </button>
                        </form>
                        <form action="{{ route('processExport',['type' => 'fNames']) }}" method="POST">
                            @csrf
                            <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                                Noms et prénoms erronés
                            </button>
                        </form>
                    </div>
                    <div class="flex justify-between bg-white pt-2 pb-2">
                        {{-- @if($currentStep == 1) --}}
                        {{-- <div></div> --}}
                        {{-- @endif --}}
            
                        {{-- @if($currentStep == 2 || $currentStep == 3) --}}
                        <button type="button" class="btn btn-md btn-secondary " wire:click="decreaseStep()">Retour</button>
                        {{-- @endif --}}
            
                        {{-- @if($currentStep == 1 || $currentStep == 2) --}}
                        {{-- <button type="button" class="btn btn-md btn-success" wire:click="increaseStep()">Suivant</button> --}}
                        {{-- @endif --}}
                    </div>
                </div>
            @endif
        </div>
        
    </x-slot>
</x-app-layout>