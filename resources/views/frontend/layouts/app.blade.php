<x-frontend.layouts.base>
    <div class="relative bg-white border-b-2 border-gray-50 ">
        <div class="mx-auto px-4 sm:px-6">
            <div class="flex justify-between items-center py-6 md:justify-start md:space-x-10">
                <div class="lg:w-0 lg:flex-1">
                    <a class="flex" href="{{ route('start') }}">
                        <img class="h-8 w-auto sm:h-10" src="{{ asset('images/carmarket-logo-transparent.png') }}" alt="">
                    </a>
                </div>
                <nav class="hidden md:flex space-x-10">
                    <div class="relative pr-4">
                        <a href="{{ route('vehicle-search') }}" class="{{ \App\Service\NavigationHelper::toggleActive('vehicle-search') }} clickable" type="button">
                            <span>Vehicles</span>
                        </a>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->isOneOfRoles(['Buyer', 'Administrator', 'Logistics']))
                        <div class="relative">
                            <button x-data="{id: 2}" @click="$dispatch('open-dropdown',{id})" class="{{ \App\Service\NavigationHelper::toggleActive('enquiry.list') }}" type="button">
                                <span>Enquiries</span>
                                <svg class="text-gray-400 h-5 w-5 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="relative">
                            <button x-data="{id: 3}" @click="$dispatch('open-dropdown',{id})" class="{{ \App\Service\NavigationHelper::toggleActive('order.list') }}" type="button">
                                <span>Orders</span>
                                <svg class="text-gray-400 h-5 w-5 group-hover:text-gray-500 group-focus:text-gray-500 transition ease-in-out duration-150" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    @endif
                    @if(\Illuminate\Support\Facades\Auth::user()->isUploader())
                        <div class="relative">
                            <a href="{{ route('car.upload') }}" class="{{ \App\Service\NavigationHelper::toggleActive('car.upload') }} clickable" type="button">
                                <span>Upload</span>
                            </a>
                        </div>
                    @endif
                </nav>
                <div class="hidden md:flex items-center justify-end space-x-8 md:flex-1 lg:w-0">
                    <div class="hidden md:flex items-center justify-end space-x-8 md:flex-1 lg:w-0">
                        <div class="p-1 border-2 border-transparent text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:text-gray-500 focus:bg-gray-100 transition duration-150 ease-in-out">
                            <livewire:go-to-cart-button />
                        </div>
                        <div class="ml-0 relative">
                            <div @click.away="open = false" class="relative" x-data="{ open: false }" x-cloak>
                                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="border-4 absolute left-0 top-12 z-30 mt-2 -mr-1 w-48 rounded-md shadow-lg">
                                    <div class="py-1 rounded-md bg-white shadow-xs relative">
                                        <a href="{{ route('user-profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">Profile</a>
                                        <hr>
                                        <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150" href="{{ route('analytics', ['type' => 'dashboard']) }}">Analytics</a>
                                        <hr>
                                        @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                                            <a href="{{ route('nova.login') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">Admin Panel</a>
                                            <hr>
                                        @endif
                                        <a href="{{ route('nova.logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition ease-in-out duration-150">Sign out</a>
                                    </div>
                                </div>
                                <div>
                                    <button type="button" id="options-menu" aria-haspopup="true" aria-expanded="true" @click="open = !open" x-bind:aria-expanded="open">
                                        <div class="group w-full rounded-md profile-padding py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-purple-500" id="options-menu" aria-haspopup="true" aria-expanded="true">
                                              <span class="flex w-full justify-between items-center">
                                                <span class="flex min-w-0 items-center justify-between space-x-3">
                                                  <img class="w-10 h-10 rounded-full flex-shrink-0" src="{{ auth()->user()->avatarUrl() }}" onerror=this.src="{{ asset('images/ef_signet.png') }}" alt="">
                                                  <span class="flex-1 min-w-0 text-left">
                                                    <span class="text-gray-900 text-sm font-medium truncate"> {{ \Illuminate\Support\Facades\Auth::user()->name }}</span><br />
                                                  </span>
                                                </span>
                                              </span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Enquiries section--}}
    {{-----------------------------------------------------------------------------------------------------------}}
    @include('frontend.partials.navigation.enquiries')
    {{--Orders section--}}
    {{-----------------------------------------------------------------------------------------------------------}}
    @include('frontend.partials.navigation.orders')
    {{--Mobile navigation--}}
    {{-----------------------------------------------------------------------------------------------------------}}
    @include('frontend.partials.navigation.mobile')
    {{-----------------------------------------------------------------------------------------------------------}}
    <div class="h-screen flex bg-white" x-data="{sidebarOpen: false}" x-cloak>
        <livewire:overlays.slide-over />
        <livewire:overlays.modal />
        <!-- Main column -->
        <div class="flex flex-col w-0 flex-1">
            <div class="border-b border-gray-200 px-4 ppb flex items-center justify-between sm:px-6 lg:px-8">
                <button style="margin-left: auto;" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-purple-500 lg:hidden" x-data="{id: 999}" @click="$dispatch('open-dropdown',{id})">
                    <span class="sr-only">Open sidebar</span>
                    <!-- Heroicon name: outline/menu-alt-1 -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                    </svg>
                </button>
            </div>
            <div class="flex-1 relative flex" wire:init="initializeFilters">
                <main class="flex-1 relative overflow-y-auto focus:outline-none xl:order-last" tabindex="0">
                    <div class="absolute inset-0">
                        <div class="h-full">
                            {{ $slot }}
                            @include('frontend.partials.footer')
                        </div>
                    </div>
                </main>
                @if(isset($aside))
                    <aside class="hidden relative xl:order-first xl:flex xl:flex-col flex-shrink-0 w-72 border-r border-gray-200">
                        <!-- Start secondary column (hidden on smaller screens) -->
                        <div class="absolute inset-0 py-6 px-4 sm:px-6 lg:px-8">
                            <div class="h-full">
                                {{ $aside }}
                            </div>
                        </div>
                        <!-- End secondary column -->
                    </aside>
                @endif
            </div>
        </div>
    </div>
</x-frontend.layouts.base>
