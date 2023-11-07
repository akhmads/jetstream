
<div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800 z-50">
  <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row">
    <div class="p-4 flex flex-row items-center justify-between">
      <a href="{{ url('/') }}" class="text-2xl font-semibold text-gray-900 rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">HyperCode</a>
      <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
          <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
        <x-hyco.nav-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard*')">
            {{ __('Dashboard') }}
        </x-hyco.nav-item>
        <x-hyco.nav-item href="{{ route('example') }}" :active="request()->routeIs('example*')">
            {{ __('Example') }}
        </x-hyco.nav-item>
        <x-hyco.nav-item href="{{ route('post') }}" :active="request()->routeIs('post*')">
            {{ __('Post') }}
        </x-hyco.nav-item>
        <x-hyco.nav-item href="{{ route('user') }}" :active="request()->routeIs('user*')">
            {{ __('User') }}
        </x-hyco.nav-item>
        <x-hyco.nav-dropdown :title="_('Master Data')" :active="request()->routeIs('master*')">
            <x-hyco.nav-dropdown-item href="{{ route('contact') }}">
                {{ __('Contact') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('item') }}">
                {{ __('Item') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('coa') }}">
                {{ __('Chart Of Account') }}
            </x-hyco.nav-dropdown-item>
        </x-hyco.nav-dropdown>
    </nav>
  </div>
</div>
