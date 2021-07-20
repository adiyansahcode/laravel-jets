<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 transition-opacity">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>​
    <div role="dialog" aria-modal="true" aria-labelledby="modal-headline"
      class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <form novalidate>
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
          <div>
            <x-jet-label for="name" value="{{ __('Name') }}" />
            @php
            $borderColor = $errors->has('name')
            ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
            : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
            @endphp
            <x-input id="name" name="name" wire:model="name"
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
            <x-input id="email" name="email" type="email" wire:model="email"
              class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
            <x-error field="email" class="mt-1 font-medium text-sm text-red-600" />
          </div>

          <div class="mt-4">
            <x-jet-label for="password" value="{{ __('Password') }}" />
            @php
            $borderColor = $errors->has('password')
            ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
            : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
            @endphp
            <x-form.password-show id="password" name="password" wire:model="password"
              class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}" />
            <x-error field="password" class="mt-1 font-medium text-sm text-red-600" />
          </div>

          <div class="mt-4">
            <x-jet-label for="Role" value="{{ __('Role') }}" />
            @php
            $borderColor = $errors->has('password_confirmation')
            ? 'border-red-300 focus:border-red-300 focus:ring-red-300'
            : 'border-gray-300 focus:border-jets-300 focus:ring-jets-300';
            @endphp
            <select name="role" id="role" wire:model="role"
              class="mt-1 block w-full rounded-md shadow-sm focus:ring focus:ring-opacity-50 {{ $borderColor }}">
              <option value='' selected="true" disabled="disabled">--choose data--</option>
              @foreach($roles as $roleId => $roleTitle)
              <option value="{{ $roleId }}">{{ $roleTitle }}</option>
              @endforeach
            </select>
            <x-error field="role" class="mt-1 font-medium text-sm text-red-600" />
          </div>
        </div>

        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
          <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
            <button wire:click.prevent="store()" type="button"
              class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
              Save
            </button>
          </span>
          <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
            <button wire:click="closeModal()" type="button"
              class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
              Cancel
            </button>
          </span>
        </div>
      </form>
    </div>
  </div>
</div>
