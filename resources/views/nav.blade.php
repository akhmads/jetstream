
<div class="w-full text-gray-700 bg-white dark-mode:text-gray-200 dark-mode:bg-gray-800">
  <div x-data="{ open: false }" class="flex flex-col max-w-screen-xl px-4 mx-auto lg:items-center lg:justify-between lg:flex-row">
    <div class="p-4 flex flex-row items-center justify-between">
      <a href="{{ url('/dashboard') }}" class="text-2xl font-semibold text-gray-900 rounded-lg dark-mode:text-white focus:outline-none focus:shadow-outline">
        <x-hyco.logo class="h-[38px]" />
      </a>
      <button class="lg:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
        <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
          <path x-show="!open" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          <path x-show="open" fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
        </svg>
      </button>
    </div>
    <nav :class="{'flex': open, 'hidden': !open}" class="flex-col flex-grow pb-4 lg:pb-0 hidden lg:flex lg:justify-end lg:flex-row">
        <x-hyco.nav-item href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard*')">
            {{ __('Dashboard') }}
        </x-hyco.nav-item>
        <x-hyco.nav-dropdown :title="_('Experiment')" :active="request()->routeIs('experiment*')">
            <x-hyco.nav-dropdown-item href="{{ route('example') }}">
                {{ __('Example') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('post') }}">
                {{ __('Post') }}
            </x-hyco.nav-dropdown-item>
        </x-hyco.nav-dropdown>
        <x-hyco.nav-dropdown :title="_('Cash & Bank')" :active="request()->routeIs(['cash*','bank*'])">
            <x-hyco.nav-dropdown-item href="{{ route('cash_bank.cash','in') }}">
                {{ __('Cash In') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('cash_bank.cash','out') }}">
                {{ __('Cash Out') }}
            </x-hyco.nav-dropdown-item>
        </x-hyco.nav-dropdown>
        <x-hyco.nav-dropdown :title="_('Finance')" :active="request()->routeIs('finance*')">
            <x-hyco.nav-dropdown-item href="{{ route('finance.journal') }}">
                {{ __('Journal') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('finance.gl') }}">
                {{ __('General Ledger') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('finance.trial-balance') }}">
                {{ __('Trial Balance') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('finance.beginning-balance') }}">
                {{ __('Beginning Balance') }}
            </x-hyco.nav-dropdown-item>
        </x-hyco.nav-dropdown>
        <x-hyco.nav-dropdown :title="_('Master Data')" :active="request()->routeIs('master*')">
            <x-hyco.nav-dropdown-item href="{{ route('master.contact') }}">
                {{ __('Contact') }}
            </x-hyco.nav-dropdown-item>
            {{-- <x-hyco.nav-dropdown-item href="{{ route('salesman') }}">
                {{ __('Salesman') }}
            </x-hyco.nav-dropdown-item> --}}
            <x-hyco.nav-dropdown-item href="{{ route('item') }}">
                {{ __('Item') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('coa') }}">
                {{ __('Chart Of Account') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('master.bank') }}">
                {{ __('Bank') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('master.bank-account') }}">
                {{ __('Bank Account') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('master.cash-account') }}">
                {{ __('Cash Account') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('master.currency') }}">
                {{ __('Currency') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('master.res-code') }}">
                {{ __('Resource Code') }}
            </x-hyco.nav-dropdown-item>
        </x-hyco.nav-dropdown>
        <x-hyco.nav-dropdown :title="auth()->user()->name">
            <x-hyco.nav-dropdown-item href="{{ route('user') }}">
                {{ __('User') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('auth.change-profile') }}">
                {{ __('Change Profile') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('auth.change-password') }}">
                {{ __('Change Password') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item href="{{ route('setting.common') }}">
                {{ __('Settings') }}
            </x-hyco.nav-dropdown-item>
            <x-hyco.nav-dropdown-item class="cursor-pointer">
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                    <span @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </span>
                </form>
            </x-hyco.nav-dropdown-item>
        </x-hyco.nav-dropdown>
    </nav>
  </div>
</div>
