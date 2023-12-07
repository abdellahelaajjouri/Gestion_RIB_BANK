<x-app-layout class="bg-white ">
    <x-slot name="header" class="h-full">


    <div class="xl:ml-52">
        <div class="py-5 pl-2">
                <form action="{{route('create')}}" method="get" >
                    <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2  focus:outline-none">Ajouter</button>
                </form>
        </div>    
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg border-black">
                
                <table class="w-full text-sm text-left text-black-500 ">
                    <thead class="text-xs text-black-700 uppercase bg-black-50 ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                RIB
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Raison social
                            </th>
                            <!-- <th scope="col" class="px-6 py-3">
                                Motif
                            </th> -->
                            <th scope="col" class="px-6 py-3">
                                NNE
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <span class="sr-only">actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($infos as $info)
                            <tr class="bg-white ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap ">
                                    {{$info->rib}}
                                </th>
                                <td class="px-6 py-4">
                                    {{$info->raison_sociale}}
                                </td>
                                <!-- <td class="px-6 py-4">
                                    {{$info->motif_prelev}}
                                </td> -->
                                <td class="px-6 py-4">
                                    {{$info->nne}}
                                </td>
                                <td class="px-6 py-4 text-right flex md:flex-col xl:flex-row items-center">
                                    <form action="{{ route('getFormData',['id' => $info->id]) }}" method="GET">
                                        @csrf
                                        <button type="submit" class="font-medium text-gray-400  hover:underline px-3" >Modifier</button>
                                    </form>
                                    <button type="button" data-modal-target="popup-modal{{$info->id}}" data-modal-toggle="popup-modal{{$info->id}}" class="font-medium text-red-600 dark:text-red-500 hover:underline px-3">Supprimer</button>
                                </td>
                            </tr>
                            <div id="popup-modal{{$info->id}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow ">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center " data-modal-hide="popup-modal{{$info->id}}">
                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                        <div class="p-6 text-center">
                                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 ">Êtes-vous sûr de vouloir supprimer cet organisme ?</h3>
                                            <div class="flex justify-center">
                                                <form action="{{ route('delete',$info->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                        <button  type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300  font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                                            Oui, je suis sûr
                                                        </button>
                                                </form>
                                                <button data-modal-hide="popup-modal{{$info->id}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10">Non, annule</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </tbody>
                </table>
            </div>
    
        </div>
    </div>


    </x-slot>
</x-app-layout>