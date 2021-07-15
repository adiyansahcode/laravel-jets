<div class="flex item-center justify-center">
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <a href="{{ route('users.show', $row) }}">
      <x-heroicon-o-eye />
    </a>
  </div>
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <a href="{{ route('users.edit', $row) }}">
      <x-heroicon-o-pencil />
    </a>
  </div>
  <div class="w-5 mr-3 transform text-gray-600 hover:text-jets-600 hover:scale-110">
    <form class="inline-block" action="{{ route('users.destroy', $row) }}" method="POST" onsubmit="return confirm('Are you sure?');">
      <input type="hidden" name="_method" value="DELETE">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <button type="submit">
        <x-heroicon-o-trash />
      </button>
    </form>
  </div>
</div>
