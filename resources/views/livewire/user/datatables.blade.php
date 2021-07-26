<x-livewire-tables::table.cell>

  <div class="flex items-center">
    <div class="flex-shrink-0 h-10 w-10">
      <img class="h-10 w-10 rounded-full" src="{{ $row->profile_photo_url }}" alt="{{ $row->username }}">
    </div>
    <div class="ml-4">
      <div class="text-sm text-gray-500 capitalize">
        {{ $row->name }}
      </div>
      <div class="text-sm font-medium text-gray-900">
        {{ $row->username }}
      </div>
    </div>
  </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <div class='text-sm text-gray-900'> {{ $row->email }} </div>
  <div class='text-sm text-gray-500'> Verified At: {{ ($row->email_verified_at) ? ($row->email_verified_at->isoFormat('D MMMM YYYY')) : null }} </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <div class="text-sm">
    {{ $row->phone }}
  </div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-jets-100 text-jets-800 capitalize'>
    {{ ($row->role) ? ($row->role->title) : null }}
  </span>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  @if($row->is_active == 1)
    <x-heroicon-o-check-circle class="w-7 inline-flex text-green-500" />
  @else
    <x-heroicon-o-x-circle class="w-7 inline-flex text-red-500" />
  @endif
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
  <div class='text-sm text-gray-900'>At: {{ ($row->updated_at) ? ($row->updated_at->isoFormat('D MMMM YYYY')) : null }}</div>
  <div class='text-sm text-gray-500'>By: {{ $row->updatedBy->username }}</div>
</x-livewire-tables::table.cell>

<x-livewire-tables::table.cell>
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
</x-livewire-tables::table.cell>
