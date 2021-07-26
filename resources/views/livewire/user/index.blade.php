<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight uppercase">
      {{ $title }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between">
      @can('userCreate')
      <button wire:click="$emit('userCreate')"
        class="bg-jets-500 hover:bg-jets-700 text-white font-bold py-2 px-2 rounded">
        <x-heroicon-o-user-add class="w-5 mr-2 inline-flex" />
        <span class="inline-flex text-sm">Create User</span>
      </button>
      @endcan

      <x-jet-action-message on="showMessage" role="alert" class="py-2 px-2 text-jets-700 bg-jets-100 rounded-lg">
        {{ session('message') }}
      </x-jet-action-message>
    </div>

    <livewire:user.datatables />

    @can('userCreate')
    @include('livewire.user.create')
    @endcan

    @can('userUpdate')
    @include('livewire.user.update')
    @endcan

    @can('userDetail')
    @include('livewire.user.detail')
    @endcan

    @can('userDelete')
    @include('livewire.user.delete')
    @endcan
  </div>
</div>
