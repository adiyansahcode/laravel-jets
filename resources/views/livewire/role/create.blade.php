@if($createModal)
<x-jet-dialog-modal wire:model="createModal" maxWidth="lg">
  <x-slot name="title">
    {{ $titleLayout }} Create Form
  </x-slot>

  <x-slot name="content">
    <div>
      <x-jet-label for="title" value="title" class="capitalize" />
      @php
      $borderColor = $errors->has('title')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="title" name="title" wire:model.defer="title"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="title" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="detail" value="detail" class="capitalize" />
      @php
      $borderColor = $errors->has('detail')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-textarea id="detail" name="detail" wire:model.defer="detail"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="detail" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="permissionId" value="permission" class="capitalize" />
      <div class="mt-2">
        @foreach($permissions as $permissionsId => $permissionsTitle)
        <div>
          <label class="inline-flex items-center">
            <x-checkbox name="permissionId.{{ $permissionsId }}" id="permissionId.{{ $permissionsId }}" value="{{ $permissionsId }}" wire:model.defer="permissionId"
              class="rounded border-jets-300 text-jets-600 shadow-sm focus:ring focus:border-jets-300 focus:ring-jets-200 focus:ring-opacity-50" />
            <span class="ml-2 capitalize"> {{ $permissionsTitle }} </span>
          </label>
        </div>
        @endforeach
      </div>
      <x-error field="permissionId" class="mt-1 font-medium text-sm text-red-600" />
    </div>
  </x-slot>

  <x-slot name="footer">
    <x-jet-secondary-button wire:click="$toggle('createModal')" wire:loading.attr="disabled">
      {{ __('Cancel') }}
    </x-jet-secondary-button>

    <x-jet-button wire:click.prevent="store()" wire:loading.attr="disabled"
      class="items-center px-4 py-2 bg-jets-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-jets-700 active:bg-jets-900 focus:outline-none focus:border-jets-900 focus:ring focus:ring-jets-300 disabled:opacity-25 transition">
      {{ __('Save') }}
    </x-jet-button>
  </x-slot>
</x-jet-dialog-modal>
@endif
