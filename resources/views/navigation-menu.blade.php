<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
  <!-- Primary Navigation Menu -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between h-16">
      <div class="flex">
        <!-- Logo -->
        <div class="flex-shrink-0 flex items-center">
          <a href="{{ route('dashboard') }}">
            <x-jet-application-mark class="block h-9 w-auto" />
          </a>
        </div>

        <!-- Navigation Links -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
          <x-jet-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
          </x-jet-nav-link>
        </div>

        @if (Auth::user())
        @canany(['roleAccess', 'userAccess'])
        <!-- Users Management -->
        <div class="hidden space-x-8 sm:-my-px sm:ml-6 sm:flex">
          <x-jet-dropdown align="left" width="60">
            <x-slot name="trigger">
              @php
              $navClass = (request()->routeIs('users.*'))
              ? 'inline-flex items-center px-1 pt-6 pb-5 border-b-2 border-jets-400 text-sm font-medium leading-5
              text-gray-900 focus:outline-none focus:border-jets-700 transition'
              : 'inline-flex items-center px-1 pt-6 pb-5 border-b-2 border-transparent text-sm font-medium leading-5
              text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700
              focus:border-gray-300 transition';
              @endphp
              <span class="{{ $navClass }}">
                <button type="button">
                  Users Management

                  <x-heroicon-o-chevron-up x-show="open" class="w-4 ml-1 inline-flex" x-cloak />
                  <x-heroicon-o-chevron-down x-show="!open" class="w-4 ml-1 inline-flex" x-cloak />
                </button>
              </span>
            </x-slot>

            <x-slot name="content">
              <div class="w-60">
                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ __('Users Management') }}
                </div>

                @can('roleAccess')
                <x-jet-dropdown-link href="#">
                  {{ __('Role') }}
                </x-jet-dropdown-link>
                @endcan

                @can('userAccess')
                <x-jet-dropdown-link href="{{ route('users.index') }}">
                  {{ __('Users') }}
                </x-jet-dropdown-link>
                @endcan
              </div>
            </x-slot>
          </x-jet-dropdown>
        </div>
        @endcanany
        @endif
      </div>

      @if (!Auth::user())
      <div class="flex">
        <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
          <x-jet-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
            Sign In
          </x-jet-nav-link>
        </div>

        <div class="hidden space-x-8 sm:-my-px sm:ml-5 sm:flex">
          <x-jet-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
            Sign Up
          </x-jet-nav-link>
        </div>
      </div>
      @endif

      @if (Auth::user())
      <div class="hidden sm:flex sm:items-center sm:ml-5">
        <!-- Settings Dropdown -->
        <div class="ml-3 relative">
          <x-jet-dropdown align="right" width="48">
            <x-slot name="trigger">
              @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
              <button
                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                  alt="{{ Auth::user()->name }}" />
              </button>
              @else
              <span class="inline-flex rounded-md">
                <button type="button"
                  class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                  {{ Auth::user()->name }}

                  <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd" />
                  </svg>
                </button>
              </span>
              @endif
            </x-slot>

            <x-slot name="content">
              <!-- Account Management -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Manage Account') }}
              </div>

              <x-jet-dropdown-link href="{{ route('profile.show') }}">
                {{ __('Profile') }}
              </x-jet-dropdown-link>

              @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
              <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                {{ __('API Tokens') }}
              </x-jet-dropdown-link>
              @endif

              <div class="border-t border-gray-100"></div>

              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                  {{ __('Sign Out') }}
                </x-jet-dropdown-link>
              </form>
            </x-slot>
          </x-jet-dropdown>
        </div>
      </div>
      @endif

      <!-- Hamburger -->
      <div class="-mr-2 flex items-center sm:hidden">
        <button @click="open = ! open"
          class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition">
          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Responsive Navigation Menu -->
  <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
      <x-jet-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
        {{ __('Dashboard') }}
      </x-jet-responsive-nav-link>

      @if (Auth::user())
      @canany(['roleAccess', 'userAccess'])
      <div class="border-t border-gray-200"></div>

      <div class="block px-4 py-2 text-xs text-gray-400">
        {{ __('Users Management') }}
      </div>

      @can('roleAccess')
      <x-jet-responsive-nav-link href="#">
        {{ __('Role') }}
      </x-jet-responsive-nav-link>
      @endcan

      @can('userAccess')
      <x-jet-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
        {{ __('Users') }}
      </x-jet-responsive-nav-link>
      @endcan
      @endcanany
      @endif

      @if (!Auth::user())
      <div class="border-t border-gray-200"></div>

      <x-jet-responsive-nav-link href="{{ route('login') }}" :active="request()->routeIs('login')">
        Sign In
      </x-jet-responsive-nav-link>

      <x-jet-responsive-nav-link href="{{ route('register') }}" :active="request()->routeIs('register')">
        Sign Up
      </x-jet-responsive-nav-link>
      @endif
    </div>

    <!-- Responsive Settings Options -->
    @if (Auth::user())
    <div class="pt-4 pb-1 border-t border-gray-200">
      <div class="flex items-center px-4">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
        <div class="flex-shrink-0 mr-3">
          <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
            alt="{{ Auth::user()->name }}" />
        </div>
        @endif

        <div>
          <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
          <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
        </div>
      </div>

      <div class="mt-3 space-y-1">
        <!-- Account Management -->
        <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
          {{ __('Profile') }}
        </x-jet-responsive-nav-link>

        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}"
          :active="request()->routeIs('api-tokens.index')">
          {{ __('API Tokens') }}
        </x-jet-responsive-nav-link>
        @endif

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf

          <x-jet-responsive-nav-link href="{{ route('logout') }}" onclick="event.preventDefault();
                                    this.closest('form').submit();">
            {{ __('Sign Out') }}
          </x-jet-responsive-nav-link>
        </form>
      </div>
    </div>
    @endif
  </div>
</nav>
