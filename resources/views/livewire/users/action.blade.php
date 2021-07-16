<div class="flex item-center justify-center">
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <button wire:click="edit({{ $row->id }})">
      <x-heroicon-o-pencil />
    </button>
  </div>
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <button wire:click="delete({{ $row->id }})">
      <x-heroicon-o-trash />
    </button>
  </div>
</div>
