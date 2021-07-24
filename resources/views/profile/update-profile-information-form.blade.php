<x-jet-form-section submit="updateProfileInformation">
  <x-slot name="title">
    {{ __('Profile Information') }}
  </x-slot>

  <x-slot name="description">
    {{ __('Update your account\'s profile information and email address.') }}
  </x-slot>

  <x-slot name="form">
    <!-- Profile Photo -->
    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
    <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
      <!-- Profile Photo File Input -->
      <input type="file" class="hidden" wire:model="photo" x-ref="photo" x-on:change="
              photoName = $refs.photo.files[0].name;
              const reader = new FileReader();
              reader.onload = (e) => {
                  photoPreview = e.target.result;
              };
              reader.readAsDataURL($refs.photo.files[0]);
      " />

      <x-jet-label for="photo" value="{{ __('Photo') }}" />

      <!-- Current Profile Photo -->
      <div class="mt-2" x-show="! photoPreview">
        <img src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}"
          class="rounded-full h-20 w-20 object-cover">
      </div>

      <!-- New Profile Photo Preview -->
      <div class="mt-2" x-show="photoPreview">
        <span class="block rounded-full w-20 h-20"
          x-bind:style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
        </span>
      </div>

      <x-jet-secondary-button class="mt-2 mr-2" type="button" x-on:click.prevent="$refs.photo.click()">
        {{ __('Select A New Photo') }}
      </x-jet-secondary-button>

      @if ($this->user->profile_photo_path)
      <x-jet-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
        {{ __('Remove Photo') }}
      </x-jet-secondary-button>
      @endif

      <x-jet-input-error for="photo" class="mt-2" />
    </div>
    @endif

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="name" value="name" class="capitalize" />
      @php
      $borderColor = $errors->has('name')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="name" name="name" wire:model.defer="state.name" autocomplete="name"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="name" class="relative py-3 px-3 leading-normal text-red-700 bg-red-100 rounded-lg" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="username" value="username" class="capitalize" />
      @php
      $borderColor = $errors->has('username')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="username" name="username" wire:model.defer="state.username"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="username" class="relative py-3 px-3 leading-normal text-red-700 bg-red-100 rounded-lg" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="email" value="email" class="capitalize" />
      @php
      $borderColor = $errors->has('email')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="email" name="email" type="email" wire:model.defer="state.email"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="email" class="relative py-3 px-3 leading-normal text-red-700 bg-red-100 rounded-lg" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="phone" value="phone number" class="capitalize" />
      @php
      $borderColor = $errors->has('phone')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-input id="phone" name="phone" wire:model.defer="state.phone"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="phone" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="date_of_birth" value="date of birth" class="capitalize" />
      @php
      $borderColor = $errors->has('dateOfBirth')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-pikaday id="date_of_birth" name="date_of_birth" format="YYYY-MM-DD" wire:model.defer="state.date_of_birth"
        x-on:change="$wire.set('state.date_of_birth', $event.target.value)" :options="[
          'firstDay' => 0,
          'yearRange' => [1970,2030],
        ]" class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="date_of_birth" class="mt-1 font-medium text-sm text-red-600" />
    </div>

    <div class="col-span-6 sm:col-span-4">
      <x-jet-label for="address" value="address" class="capitalize" />
      @php
      $borderColor = $errors->has('address')
      ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
      : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
      @endphp
      <x-textarea id="address" name="address" wire:model.defer="state.address"
        class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
      <x-error field="address" class="mt-1 font-medium text-sm text-red-600" />
    </div>

  </x-slot>

  <x-slot name="actions">
    <x-jet-action-message on="saved" role="alert" class="items-center px-4 py-2 text-xs text-green-700 bg-green-100 rounded-lg" >
      {{ __('Saved.') }}
    </x-jet-action-message>

    <button type="submit" wire:loading.attr="disabled" wire:target="photo"
      class="items-center px-4 py-2 bg-jets-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-jets-700 active:bg-jets-900 focus:outline-none focus:border-jets-900 focus:ring focus:ring-jets-300 disabled:opacity-25 transition">
      Save
    </button>
  </x-slot>
</x-jet-form-section>
