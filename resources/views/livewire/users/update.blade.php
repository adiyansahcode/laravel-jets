@if($updateModal)
<x-jet-dialog-modal wire:model="updateModal" maxWidth="lg">
  <x-slot name="title">
    Users Edit Form
  </x-slot>

  <x-slot name="content">
    <div>
      <x-jet-label for="name" value="name" class="capitalize" />
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
      <x-jet-label for="email" value="email" class="capitalize" />
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
      <x-jet-label for="phone" value="phone number" class="capitalize" />
      @php
      $borderColor = $errors->has('phone')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="phone" name="phone" wire:model.defer="phone"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="phone" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="dateOfBirth" value="date of birth" class="capitalize" />
      @php
      $borderColor = $errors->has('dateOfBirth')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-pikaday id="dateOfBirth" name="dateOfBirth" format="YYYY-MM-DD"
        wire:model.defer="dateOfBirth"
        x-on:change="$wire.set('dateOfBirth', $event.target.value)"
        :options="[
          'firstDay' => 0,
          'yearRange' => [1970,2030],
        ]"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="dateOfBirth" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="Role" value="role" class="capitalize" />
      @php
      $borderColor = $errors->has('password_confirmation')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <select name="roleId" id="roleId" wire:model.defer="roleId"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}">
        <option value='0' selected="true" disabled="disabled">--choose data--</option>
        @foreach($roles as $rolesId => $rolesTitle)
          <option value="{{ $rolesId }}" {{ ($rolesId === $roleId) ? 'selected' : '' }}>{{ $rolesTitle }}</option>
        @endforeach
      </select>
      <x-error field="role" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="mt-4">
      <x-jet-label for="address" value="address" class="capitalize" />
      @php
      $borderColor = $errors->has('address')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-textarea id="address" name="address" wire:model.defer="address"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="address" class="mt-1 font-medium text-sm text-red-600" />
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

