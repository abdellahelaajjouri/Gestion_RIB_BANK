<x-app-layout class="bg-white ">
    <x-slot name="header" class="h-full">

        <div class="bg-white shadow-md rounded-lg p-4">
            <form action="{{ route('index.import') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="file" class="block text-gray-700 text-sm font-bold mb-2">Choisir un fichier:</label>
                    <input type="file" name="file" id="file" class="bg-gray-100 p-2 w-full rounded">

                    @error('file')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <button class="bg-green-500 w-full h-12 rounded text-white text-3xl mb-3">Importer</button>
            </form>

            <button type="button" data-modal-target="crypto-modal" data-modal-toggle="crypto-modal"
                class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-xl px-5 py-2.5 justify-center text-center inline-flex items-center w-full">
                Exporter
            </button>

            <!-- Main modal -->
            <div id="crypto-modal" tabindex="-1" aria-hidden="true"
                class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center"
                            data-modal-hide="crypto-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <!-- Modal header -->
                        <div class="px-6 py-4 border-b rounded-t">
                            <h3 class="text-base font-semibold text-gray-900 lg:text-xl">
                                Veuillez choisir votre choix
                            </h3>
                        </div>
                        <!-- Modal body -->
                        <div class="p-6">
                            <p class="text-sm font-normal text-gray-500">
                                Exporter
                            </p>
                            <ul class="my-4 space-y-3">
                                <li>
                                    <form action="{{ route('filter.exportCDM') }}" method="POST">
                                        @csrf

                                        <button
                                            class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow">
                                            <span class="flex-1 ml-3 whitespace-nowrap">Crédit du Maroc</span>
                                            <span
                                                class="inline-flex items-center justify-center px-2 py-0.5 ml-3 text-xs font-medium text-gray-500 bg-gray-200 rounded">Popular</span>
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('filter.exportAutreBanck') }}" method="POST">
                                        @csrf

                                        <button
                                            class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow">
                                            <span class="flex-1 ml-3 whitespace-nowrap">Autre Bank</span>
                                        </button> 
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('filter.exportRibEroné') }}" method="POST">
                                            @csrf
                                        <button
                                            class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow">
                                            <span class="flex-1 ml-3 whitespace-nowrap">Ribe érronées</span>
                                        </button>
                                    </form>
                                </li>



                            </ul>

                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div  class="bg-white shadow-md rounded-lg p-4 mt-8">
            <form action="{{ route('additional-info.store') }}" method="post">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">RIB de l’organisme (24 positions):</label>
                    <input class="bg-gray-100 p-2 w-full rounded" type="text" name="rib" required value="{{ $firstRow->rib ?? '' }}">
                    @error('rib')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" >Raison sociale de l’organisme:</label>
                    <input class="bg-gray-100 p-2 w-full rounded"  type="text" name="raison_sociale" required value="{{ $firstRow->raison_sociale ?? '' }}">
                    @error('raison_sociale')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label>Motif du prélèvement (Sans caractère spécial):</label>
                    <input  class="bg-gray-100 p-2 w-full rounded" class="block text-gray-700 text-sm font-bold mb-2" type="text" name="motif_prelev" required value="{{ $firstRow->motif_prelev ?? '' }}">
                    @error('motif_prelev')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label>Date envoie du fichier (AAAAMMJJ):</label>
                    <input class="bg-gray-100 p-2 w-full rounded"  class="block text-gray-700 text-sm font-bold mb-2" type="date" name="date_envoi" required value="{{ $firstRow->date_envoi ?? '' }}">
                    @error('date_envoi')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label>Numéro national d’émetteur (NNE sur 3 positions):</label>
                    <input class="bg-gray-100 p-2 w-full rounded"  class="block text-gray-700 text-sm font-bold mb-2" type="text" name="nne" required value="{{ $firstRow->nne ?? '' }}">
                    @error('nne')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <input  type="submit" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-xl px-5 py-2.5 justify-center text-center inline-flex items-center w-full" value="Télécharger">
            </form>
        </div>

        <div class="relative overflow-x-auto mt-8">

            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Id
                        </th>

                        <th scope="col" class="px-6 py-3">
                            RIB Débiteur
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nom Débiteur
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Montant
                        </th>
                        <th scope="col" class="px-6 py-3">
                            référence contrat
                        </th>

                        <th scope="col" class="px-6 py-3">
                            référence facture
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Date d'écheance
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($parks as $item)
                        <tr class="bg-white border-b">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->id }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->rib }}
                            </th>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->nom }}
                            </th>

                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->montant }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->reference_contrat }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->reference_facture }}
                            </th>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $item->date_echeance }}
                            </th>



                        </tr>

                        @endforeach
                </tbody>
            </table>
            <div class="mt-4">
                {{ $parks->links() }}
            </div>
        </div>
    </x-slot>
</x-app-layout>