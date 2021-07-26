@if($deleteModal)
<x-jet-confirmation-modal wire:model="deleteModal">
  <x-slot name="title">
    {{ $titleLayout }} Delete Confirmation
  </x-slot>

  <x-slot name="content">
      Are you sure you would like to delete this data ?
  </x-slot>

  <x-slot name="footer">
      <x-jet-secondary-button wire:click="$toggle('deleteModal')" wire:loading.attr="disabled">
          {{ __('Cancel') }}
      </x-jet-secondary-button>

      <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
          {{ __('Delete') }}
      </x-jet-danger-button>
  </x-slot>
</x-jet-confirmation-modal>
@endif
