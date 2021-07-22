<div class="flex item-center">
  @can('userDetail')
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <button wire:click="$emit('userDetail', {{ $row->id }})">
      <x-heroicon-o-eye />
    </button>
  </div>
  @endcan
  @can('userUpdate')
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <button wire:click="$emit('userUpdate', {{ $row->id }})">
      <x-heroicon-o-pencil />
    </button>
  </div>
  @endcan
  @can('userDelete')
  <div class="w-5 mr-3 transform text-gray-600 hover:text-red-600 hover:scale-110">
    <button wire:click="$emit('userDelete', {{ $row->id }})">
      <x-heroicon-o-trash />
    </button>
  </div>
  @endcan
</div>
