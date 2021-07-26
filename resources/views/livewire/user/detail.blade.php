@if($detailModal)
<x-jet-dialog-modal wire:model="detailModal" maxWidth="sm">
  <x-slot name="title">
    Users Detail
  </x-slot>

  <x-slot name="content">
    <div class="">
      <div class="photo-wrapper p-2">
        <img class="w-32 h-32 rounded-full mx-auto" alt="{{ $name }}" src="{{ $profilePhotoUrl }}" />
      </div>
      <div class="">
        <h3 class="text-center text-xl text-gray-900 font-medium leading-8">{{ $name }}</h3>
        <div class="text-center text-gray-400 text-xs font-semibold">
            <p>{{ $roleTitle }}</p>
        </div>
        <table class="min-w-full divide-y divide-gray-200 mt-3 text-sm">
          <tbody class="bg-white divide-y divide-gray-200 text-gray-500">
            <tr>
              <td class="px-2 py-2 font-semibold capitalize">Username</td>
              <td class="">:</td>
              <td class="px-2 py-2">{{ $username }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 font-semibold capitalize">Email</td>
              <td class="">:</td>
              <td class="px-2 py-2">{{ $email }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 font-semibold capitalize">Phone Number</td>
              <td class="">:</td>
              <td class="px-2 py-2">{{ $phone }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 font-semibold capitalize">Date Of Birth</td>
              <td class="">:</td>
              <td class="px-2 py-2">{{ $dateOfBirth }}</td>
            </tr>
            <tr>
              <td class="px-2 py-2 font-semibold capitalize">Address</td>
              <td class="">:</td>
              <td class="px-2 py-2">{{ $address }}</td>
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
