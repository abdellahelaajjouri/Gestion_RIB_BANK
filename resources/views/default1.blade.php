<x-app-layout class="bg-white ">
    <x-slot name="header" class="h-full">
      <div class="container">
        <div class="row" style="margin-top : 50px">
          <div class="col-md-6 offset-md-3"> 
            @livewire('multi-step-form')
          </div>
        </div>
      </div>

  </x-slot>
</x-app-layout>