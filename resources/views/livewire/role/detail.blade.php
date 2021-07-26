@if($detailModal)
<x-jet-dialog-modal wire:model="detailModal" maxWidth="sm">
  <x-slot name="title">
    <div class="text-gray-600">
      {{ $titleLayout }} Detail
    </div>
  </x-slot>

  <x-slot name="content">
    <table class="min-w-full divide-y divide-gray-200">
      <tbody class="bg-white divide-y divide-gray-200 text-gray-500">
        <tr>
          <td class="px-2 py-2 font-semibold capitalize">Title</td>
          <td class="">:</td>
          <td class="px-2 py-2 capitalize">{{ $title }}</td>
        </tr>
        <tr>
          <td class="px-2 py-2 font-semibold capitalize">Detail</td>
          <td class="">:</td>
          <td class="px-2 py-2">{{ $detail }}</td>
        </tr>
      </tbody>
    </table>
  </x-slot>

  <x-slot name="footer">
    <x-jet-secondary-button wire:click="$toggle('detailModal')" wire:loading.attr="disabled">
      {{ __('Close') }}
    </x-jet-secondary-button>
  </x-slot>
</x-jet-dialog-modal>
@endif
