<div class="flex item-center justify-center">
  @can('userDetail')
    <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
      <button wire:click="show({{ $row->id }})">
        <x-heroicon-o-eye />
      </button>
    </div>
  @endcan
  @can('userUpdate')
    <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
      <button wire:click="edit({{ $row->id }})">
        <x-heroicon-o-pencil />
      </button>
    </div>
  @endcan
  @can('userDelete')
  <div class="w-5 mr-3 transform text-gray-600 hover:text-red-600 hover:scale-110">
    <button wire:click="delete({{ $row->id }})">
      <x-heroicon-o-trash />
    </button>
  </div>
  @endcan
</div>
