<x-app-layout class="bg-white ">
    <x-slot name="header" class="h-full">
        <div class="relative bg-white rounded-lg shadow  xl:ml-52">
            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 ">Details de l'orgarnisme</h3>
                    <form class="space-y-6" action="{{ route('update' ,['id' => $selectedIndexData->id])}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div>
                            <label for="rib" class="block mb-2 text-sm font-medium text-gray-900 ">RIB de l’organisme (24 positions):</label>
                            <input  name="rib" id="rib" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  " value="{{$selectedIndexData ? $selectedIndexData->rib  : '' }}" >
                        </div>
                        @error('rib')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <div>
                            <label for="raison_sociale" class="block mb-2 text-sm font-medium text-gray-900 ">Raison sociale de l’organisme:</label>
                            <input  name="raison_sociale" id="raison_sociale" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "  value="{{$selectedIndexData ? $selectedIndexData->raison_sociale  : '' }}" >
                        </div>
                        @error('raison_sociale')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        <!-- <div>
                            <label for="motif_prelev" class="block mb-2 text-sm font-medium text-gray-900 "> Motif du prélèvement:</label>
                            <input  name="motif_prelev" id="motif_prelev" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "  value="{{$selectedIndexData ? $selectedIndexData->motif_prelev  : '' }}" >
                        </div>
                        @error('motif_prelev')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror -->
                        <div>
                            <label for="nne" class="block mb-2 text-sm font-medium text-gray-900 "> Numéro national d’émetteur:</label>
                            <input  name="nne" id="nne" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  "  value="{{$selectedIndexData ? $selectedIndexData->nne  : '' }}"  >
                        </div>
                        @error('nne')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                        
                        <button type="submit" class="w-full text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Enregister les informations</button>
                    </form>
            </div>
        </div>
    </x-slot>
</x-app-layout>