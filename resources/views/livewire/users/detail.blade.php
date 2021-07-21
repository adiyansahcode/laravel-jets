@if($detailModal)
<x-jet-dialog-modal wire:model="detailModal" maxWidth="sm">
  <x-slot name="title">
    {{ __('Users Detail') }}
  </x-slot>

  <x-slot name="content">
    <div class="p-6">
      <div class="photo-wrapper p-2">
        <img class="w-32 h-32 rounded-full mx-auto" alt="{{ $name }}" src="{{ $profilePhotoUrl }}" />
      </div>
      <div class="p-2">
        <h3 class="text-center text-xl text-gray-900 font-medium leading-8">{{ $name }}</h3>
        <div class="text-center text-gray-400 text-xs font-semibold">
            <p>{{ $role }}</p>
        </div>
        <table class="text-xs my-3">
          <tbody>
            <tr>
              <td class="px-2 py-2 text-gray-500 font-semibold">Email</td>
              <td class="px-2 py-2">{{ $email }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 text-gray-500 font-semibold">Phone</td>
              <td class="px-2 py-2">{{ $phone }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 text-gray-500 font-semibold">Address</td>
              <td class="px-2 py-2">{{ $address }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 text-gray-500 font-semibold">Date Of Birth</td>
              <td class="px-2 py-2">{{ $dateOfBirth }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </x-slot>

  <x-slot name="footer">
    <x-jet-secondary-button wire:click="$toggle('detailModal')" wire:loading.attr="disabled">
      {{ __('Close') }}
    </x-jet-secondary-button>
  </x-slot>
</x-jet-dialog-modal>
@endif
