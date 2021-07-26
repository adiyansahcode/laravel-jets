<div>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-600 leading-tight uppercase">
      {{ $titleLayout }}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="mb-6 flex justify-between">
      @can('roleCreate')
      <button wire:click="$emit('create')"
        class="bg-jets-500 hover:bg-jets-700 text-white font-bold py-2 px-2 rounded">
        <x-heroicon-o-document-add class="w-5 mr-1 inline-flex" />
        <span class="inline-flex text-sm">Create</span>
      </button>
      @endcan

      <x-jet-action-message on="showMessage" role="alert" class="py-2 px-2 text-jets-700 bg-jets-100 rounded-lg capitalize">
        {{ session('message') }}
      </x-jet-action-message>
    </div>

    <livewire:role.datatables />

    @can('roleCreate')
    @include('livewire.role.create')
    @endcan

    @can('roleUpdate')
    @include('livewire.role.update')
    @endcan

    @can('roleDetail')
    @include('livewire.role.detail')
    @endcan

    @can('roleDelete')
    @include('livewire.role.delete')
    @endcan
  </div>
</div>
