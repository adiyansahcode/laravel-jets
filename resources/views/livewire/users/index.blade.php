<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Users List
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between">
      <button wire:click="create()" class="bg-jets-500 hover:bg-jets-700 text-white font-bold py-2 px-2 rounded">
        <x-heroicon-o-user-add class="w-5 mr-1 inline-flex" />
        <span class="inline-flex">Create User</span>
      </button>

      <x-jet-action-message on="showMessage" role="alert" class="py-2 px-2 text-jets-700 bg-jets-100 rounded-lg">
        @if (session('message'))
          {{ session('message') }}
        @endif
      </x-jet-action-message>

    </div>
    @if($createModal)
      @include('livewire.users.create')
    @endif
    @if($updateModal)
      @include('livewire.users.update')
    @endif
    <livewire:users.datatables />
  </div>
</div>
