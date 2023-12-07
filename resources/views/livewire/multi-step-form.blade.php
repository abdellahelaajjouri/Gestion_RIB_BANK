<div>
            @if($loading)
                <script>
                    document.getElementById('loading').style.display = 'none';
                </script>
            @endif 

            <script>
                function loadingData() {
                    if (document.getElementById("file").files.length > 0 && document.getElementById("file1").files.length > 0) {
                        document.getElementById('loading').style.display = 'block';
                    }
                }
            </script>

            <div id="loading" class="loading">Loading&#8230;</div>

            @if($currentStep == 1)


                        <div class=" items-center  w-full  flex-col flex justify-center">
                            <div class="text-black-1000">
                                Etape 1/3 - importer fichier
                            </div>  
                            <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                                        Choisir un fichier:
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required name="file" id="file" type="file" accept=".csv" wire:model="file">
                                    @error('file')
                                            <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="file1">
                                        Choisir fichier du code erronées:
                                    </label>
                                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required name="file1" id="file1" type="file" wire:model="file1">
                                    @error('file1')
                                            <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </form>
                            <div class="flex justify-between bg-white pt-2 pb-2">
                            @if($currentStep == 1)
                            <div></div>
                            @endif
                
                            @if($currentStep == 2 || $currentStep == 3)
                            <button type="button" class="btn btn-md btn-secondary" wire:click="decreaseStep()">Retour</button>
                            @endif
                
                            @if($currentStep == 1 || $currentStep == 2)
                            <button type="button" class="btn btn-md btn-success" wire:click="increaseStep()" onclick="loadingData()">Suivant</button>
                            @endif
                
                        </div>
                        </div>
                
            @endif
    
        @if($currentStep == 2)
            <div class="items-center  w-full  flex-col flex justify-center">
                <div class="text-black-1000">
                    Etape 2/3 - Remplissez les détails
                </div>  
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="rib">
                            RIB de l’organisme (24 positions):
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="rib" id="rib" type="text" value="{{ $firstRow->rib ?? ''}}" wire:model="rib">
                        @error('rib')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="raison_sociale">
                            Raison sociale de l’organisme:
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="raison_sociale" id="raison_sociale" type="text"  value="{{ $firstRow->raison_sociale ?? '' }}" wire:model="raison_sociale">
                        @error('raison_sociale')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="motif_prelev">
                            Motif du prélèvement (Sans caractère spécial):
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="motif_prelev" id="motif_prelev" type="text" value="{{ $firstRow->motif_prelev ?? '' }}" wire:model="motif_prelev">
                        @error('motif_prelev')
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
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nne">
                            Numéro national d’émetteur (NNE sur 3 positions):
                        </label>
                        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="nne" id="nne" type="text" wire:model="nne" value="{{ $firstRow->nne ?? '' }}">
                        @error('nne')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </form> 
                <div class="flex justify-between bg-white pt-2 pb-2">
                @if($currentStep == 1)
                <div></div>
                @endif
    
                @if($currentStep == 2 || $currentStep == 3)
                <button type="button" class="btn btn-md btn-secondary mx-7" wire:click="decreaseStep()">Retour</button>
                @endif
    
                @if($currentStep == 1 || $currentStep == 2)
                <button type="button" class="btn btn-md btn-success" wire:click="increaseStep()">Suivant</button>
                @endif
    
            </div>
            </div>
        @endif

        @if($currentStep == 3)
            <div class="items-center  w-full  flex-col flex justify-center">
                <div class="text-black-1000">
                Etape 3/3 - Exporter fichier
                </div>  
                <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                    <form action="{{ route('process',['type' => 'cdm']) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            Crédit du Maroc
                        </button>
                    </form>
                    <form action="{{ route('process',['type' => 'autre']) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            Autre Bank
                        </button>
                    </form>
                    <form action="{{ route('process',['type' => 'ribsEr']) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            Ribe erronées
                        </button>
                    </form>
                    <form action="{{ route('process',['type' => 'fNames']) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-2.5 px-5 mr-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                            Noms et prénoms faux
                        </button>
                    </form>
                </div>
                <div class="flex justify-between bg-white pt-2 pb-2">
                @if($currentStep == 1)
                <div></div>
                @endif
    
                @if($currentStep == 2 || $currentStep == 3)
                <button type="button" class="btn btn-md btn-secondary " wire:click="decreaseStep()">Retour</button>
                @endif
    
                @if($currentStep == 1 || $currentStep == 2)
                <button type="button" class="btn btn-md btn-success" wire:click="increaseStep()">Suivant</button>
                @endif
    
            </div>
            </div>
        @endif

</div>
