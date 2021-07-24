<x-base-layout :title="($title) ? $title : null">
  <div class="font-sans text-gray-900 antialiased">
    {{ $slot }}
  </div>
</x-base-layout>
