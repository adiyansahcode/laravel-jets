<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Users List
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="block mb-6">
      <a href="{{ route('users.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Add User</a>
    </div>
    <livewire:users.datatables />
  </div>
</x-app-layout>
