<div>
    <div class="mx-auto margin-card-view">
        <div class="mx-auto margin-card-view">
            <header class="mt-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        <span class="text-blue-700">{{ $cars->total() }}</span>
                        vehicles found
                    </h1>
                </div>
            </header>
            <div wire:loading >
                <div class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-500 opacity-75 flex flex-col items-center justify-center">
                    <div class="flex justify-center items-center">
                        <div
                            class="animate-spin rounded-full h-32 w-32 border-b-2 border-white-900"
                        ></div>
                    </div>
                </div>
            </div>
            <main>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="mt-4 flex h-16 items-center justify-between text-base font-normal text-gray-900">
                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input wire:model.debounce.300ms="search" type="text" name="search" id="search" class="block w-full rounded pl-10 sm:text-sm border-gray-300 placeholder-gray-300" placeholder="Search by make, model or keyword" data-np-checked="1">
                        </div>
                    </div>
                </div>
                <div class="justify-between py-4 bg-white w-full">
                    <div class="space-x-2 flex items-center pl-6">
                        <div x-data="{ perPage: false }" @click.away="perPage = false" id="desktop-menu" class="relative z-10 inline-block text-left">
                            <div>
                                <button @click="perPage =! perPage" type="button" class="group inline-flex items-center justify-center text-sm font-medium text-gray-700 hover:text-gray-900" aria-expanded="false">
                                    <span>Show Vehicles</span>

                                    <span class="ml-1.5 rounded py-0.5 px-1.5 bg-gray-200 text-xs font-semibold text-gray-700 tabular-nums">{{ $perPage }}</span>
                                    <!-- Heroicon name: solid/chevron-down -->
                                    <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 x-show="perPage"
                                 class="origin-top-right absolute right-0 mt-2 bg-white rounded-md shadow-2xl p-4 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <livewire:per-page-bulk-action :perPage="$perPage"/>
                            </div>
                        </div>
                        <div x-data="{ bulk: false }" @click.away="bulk = false" id="desktop-menu-1" class="relative z-40 inline-block text-left pl-6">
                            <div>
                                <button @click="bulk =! bulk" type="button" class="group inline-flex items-center justify-center text-sm font-medium text-gray-700 hover:text-gray-900" aria-expanded="false">
                                    <div class="flex">
                                        Bulk actions
                                        <livewire:selected-count/>
                                    </div>
                                    <!-- Heroicon name: solid/chevron-down -->
                                    <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 x-show="bulk"
                                 class="origin-top-left absolute left-0 z-10 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <livewire:vehicle-bulk-actions/>
                            </div>
                        </div>

                        <div x-data="{ sort: false }" @click.away="sort = false" class="relative z-40 inline-block text-left flex pl-6">
                            <div>
                                <button @click="sort =! sort" type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" id="mobile-menu-button" aria-expanded="false" aria-haspopup="true">
                                    Sort
                                    <!-- Heroicon name: solid/chevron-down -->
                                    <svg class="flex-shrink-0 -mr-1 ml-1 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 x-show="sort"
                                 class="origin-top-left absolute left-0 z-10 mt-2 w-40 rounded-md shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="mobile-menu-button" tabindex="-1">
                                <livewire:sort-bulk-action :sortField="$sortField" :sortDirection="$sortDirection"/>
                            </div>
                        </div>

                        @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                            <div class="pl-6">
                                <label for="toggle" class="text-xs text-gray-700">Card view</label>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                    <input wire:model="viewSwitch" type="checkbox" name="toggle" id="toggle" value="table-view" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                    <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                                </div>
                                <label for="toggle" class="text-xs text-gray-700">Table view</label>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
        <div>
            <div class="mx-auto margin-card-view mr-3">
                <div class="mt-6 grid grid-cols-2 gap-x-8 gap-y-8 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 sm:gap-y-20">
                    @foreach ($cars as $car)
                        <livewire:vehicle-card :vehicle="$car" :key="$car->manufacturer_id" :manufacturerId="$car->manufacturer_id"/>
                    @endforeach
                </div>
            </div>
            <div class="mt-6">
                {{ $cars->links('frontend.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
