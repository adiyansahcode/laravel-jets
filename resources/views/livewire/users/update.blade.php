@if($updateModal)
<x-jet-dialog-modal wire:model="updateModal" maxWidth="lg">
  <x-slot name="title">
    {{ __('Users Edit Form') }}
  </x-slot>

  <x-slot name="content">
    <div>
      <x-jet-label for="name" value="{{ __('Name') }}" />
      @php
      $borderColor = $errors->has('name')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="name" name="name" wire:model.defer="name"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="name" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="email" value="{{ __('Email') }}" />
      @php
      $borderColor = $errors->has('email')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="email" name="email" type="email" wire:model.defer="email"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="email" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="Role" value="{{ __('Role') }}" />
      @php
      $borderColor = $errors->has('password_confirmation')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <select name="role" id="role" wire:model.defer="role"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}">
        <option value='' selected="true" disabled="disabled">--choose data--</option>
        @foreach($roles as $roleId => $roleTitle)
          <option value="{{ $roleId }}" {{ ($roleId === $role) ? 'selected' : '' }}>{{ $roleTitle }}</option>
        @endforeach
      </select>
      <x-error field="role" class="mt-1 font-medium text-sm text-red-600" />
    </div>
  </x-slot>

  <x-slot name="footer">
    <x-jet-secondary-button wire:click="$toggle('updateModal')" wire:loading.attr="disabled">
      {{ __('Cancel') }}
    </x-jet-secondary-button>

    <x-jet-button wire:click.prevent="update()" wire:loading.attr="disabled"
      class="items-center px-4 py-2 bg-jets-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-jets-700 active:bg-jets-900 focus:outline-none focus:border-jets-900 focus:ring focus:ring-jets-300 disabled:opacity-25 transition">
      {{ __('Update') }}
    </x-jet-button>
  </x-slot>
</x-jet-dialog-modal>
@endif

