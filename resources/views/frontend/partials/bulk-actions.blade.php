<div class="bg-white">
    <div x-show="mobileActions" x-data="{ mobileActions: false }" class="fixed inset-0 flex z-40 sm:hidden" role="dialog" aria-modal="true">
        <div x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>
        <div x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="ml-auto relative max-w-xs w-full h-full bg-white shadow-xl py-4 pb-6 flex flex-col overflow-y-auto">
            <div class="px-4 flex items-center justify-between">
                <h2 class="text-lg font-medium text-gray-900">Actions</h2>
                <button type="button" class="-mr-2 w-10 h-10 bg-white p-2 rounded-md flex items-center justify-center text-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <span class="sr-only">Close menu</span>
                    <!-- Heroicon name: outline/x -->
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Filters -->
            <form class="mt-4">
                <div x-data="{ perPage: false }" @click.away="perPage = false" class="border-t border-gray-200 px-4 py-6">
                    <h3 class="-mx-2 -my-3 flow-root">
                        <!-- Expand/collapse question button -->
                        <button @click="perPage =! perPage" type="button" class="px-2 py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400" aria-controls="filter-section-0" aria-expanded="false">
                                              <span class="font-medium text-gray-900">
                                                Show vehicles
                                              </span>
                            <span class="ml-6 flex items-center">
                                                    <!--
                                                      Expand/collapse icon, toggle classes based on question open state.

                                                      Heroicon name: solid/chevron-down

                                                      Open: "-rotate-180", Closed: "rotate-0"
                                                    -->
                                                <svg class="rotate-0 h-5 w-5 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                              </span>
                        </button>
                    </h3>
                    <div

                        x-show="perPage"
                        class="pt-6"
                        id="filter-section-0"
                    >
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <input id="filter-mobile-category-0" name="category[]" value="tees" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="filter-mobile-category-0" class="ml-3 text-sm text-gray-500">
                                    40
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input id="filter-mobile-category-1" name="category[]" value="crewnecks" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="filter-mobile-category-1" class="ml-3 text-sm text-gray-500">
                                    80
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input id="filter-mobile-category-2" name="category[]" value="hats" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="filter-mobile-category-2" class="ml-3 text-sm text-gray-500">
                                    120
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ bulk: false }" @click.away="bulk = false" class="border-t border-gray-200 px-4 py-6">
                    <h3 class="-mx-2 -my-3 flow-root">
                        <!-- Expand/collapse question button -->
                        <button @click="bulk =! bulk" type="button" class="px-2 py-3 bg-white w-full flex items-center justify-between text-sm text-gray-400" aria-controls="filter-section-1" aria-expanded="false">
                                              <span class="font-medium text-gray-900">
                                                Bulk actions
                                              </span>
                            <span class="ml-6 flex items-center">
                                                <!--
                                                  Expand/collapse icon, toggle classes based on question open state.

                                                  Heroicon name: solid/chevron-down

                                                  Open: "-rotate-180", Closed: "rotate-0"
                                                -->
                                                <svg class="rotate-0 h-5 w-5 transform" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                              </span>
                        </button>
                    </h3>
                    <div x-show="bulk" class="pt-6" id="filter-section-1">
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <input id="filter-mobile-brand-0" name="brand[]" value="clothing-company" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="filter-mobile-brand-0" class="ml-3 text-sm text-gray-500">
                                    Add to cart
                                </label>
                            </div>

                            <div class="flex items-center">
                                <input id="filter-mobile-brand-1" name="brand[]" value="fashion-inc" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
                                <label for="filter-mobile-brand-1" class="ml-3 text-sm text-gray-500">
                                    Export list
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="max-w-3xl mx-auto px-4 text-center sm:px-6 lg:max-w-7xl lg:px-8">
        <section aria-labelledby="filter-heading" class="border-gray-200 py-6">
            <div class="flex items-center justify-between">
                <div x-data="{ sort: false }" @click.away="sort = false" class="relative z-10 inline-block text-left flex">
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
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                        <div class="ml-3">
                            <label for="toggle" class="text-xs text-gray-700">Card view</label>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input wire:model="viewSwitch" type="checkbox" name="toggle" id="toggle" value="table-view" class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="toggle" class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>
                            <label for="toggle" class="text-xs text-gray-700">Table view</label>
                        </div>
                    @endif
                </div>
                <!-- Mobile filter dialog toggle, controls the 'mobileFilterDialogOpen' state. -->
                <button type="button" class="inline-block text-sm font-medium text-gray-700 hover:text-gray-900 sm:hidden">
                    Filters
                </button>

                <div class="hidden sm:flex sm:items-baseline sm:space-x-8">
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

                    <div x-data="{ bulk: false }" @click.away="bulk = false" id="desktop-menu-1" class="relative z-10 inline-block text-left">
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
                </div>
            </div>
        </section>
    </div>
</div>
