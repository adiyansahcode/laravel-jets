<x-jet-form-section submit="updatePassword">
  <x-slot name="title">
    {{ __('Update Password') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Ensure your account is using a long, random password to stay secure.') }}
  </x-slot>

  <x-slot name="form">
    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="current_password" value="Current Password" class="capitalize" />
      @php
      $borderColor = $errors->has('current_password')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-form.password-show id="current_password" name="current_password" wire:model.defer="state.current_password"
        autocomplete="current-password"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="current_password" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="password" value="New Password" class="capitalize" />
      @php
      $borderColor = $errors->has('password')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-form.password-show id="password" name="password" wire:model.defer="state.password" autocomplete="new-password"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="password" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="password_confirmation" value="Confirm Password" class="capitalize" />
      @php
      $borderColor = $errors->has('password_confirmation')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-form.password-show id="password_confirmation" name="password_confirmation"
        wire:model.defer="state.password_confirmation" autocomplete="new-password"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="password_confirmation" class="mt-1 font-medium text-sm text-red-600" />
    </div>
  </x-slot>

  <x-slot name="actions">
    <x-jet-action-message on="saved" role="alert"
      class="items-center px-4 py-2 text-xs text-green-700 bg-green-100 rounded-lg">
      {{ __('Saved.') }}
    </x-jet-action-message>

    <button type="submit" wire:loading.attr="disabled" wire:target="photo"
      class="items-center px-4 py-2 bg-jets-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-jets-700 active:bg-jets-900 focus:outline-none focus:border-jets-900 focus:ring focus:ring-jets-300 disabled:opacity-25 transition">
      Save
    </button>
  </x-slot>
</x-jet-form-section>
