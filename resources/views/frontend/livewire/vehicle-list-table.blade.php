<div>
    <div class="mx-auto margin-table-view">
        <div class="px-4 py-8 sm:px-0">
            <header>
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold leading-tight text-gray-900">
                        <span class="text-blue-700">{{ $cars->total() }}</span>
                        vehicles found
                    </h1>
                </div>
            </header>
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
                        <x-input.select wire:model="perPage" id="perPage">
                            <option value="40">40</option>
                            <option value="80">80</option>
                            <option value="120">120</option>
                        </x-input.select>
                        <x-dropdownPicker label="Bulk Actions">
                            <x-dropdown.item @click="open = !open" type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                <x-icon.download class="text-cool-gray-400"/> <span>Export</span>
                            </x-dropdown.item>

                            <x-dropdown.item @click="open = !open" type="button" wire:click="addSelectedToCart" class="flex items-center space-x-2 text-blue-600 ">
                                @svg('heroicon-s-shopping-cart', ['class' => 'group-hover:text-blue-500 mr-1 h-5 w-5']) <span>Add to Cart</span>
                            </x-dropdown.item>
                        </x-dropdownPicker>
                        <livewire:column-preference :listColumns="$listColumns" :columnPreference="$columnPreference" :resourceClass="$resourceClass"/>
                        <div>
                            <label for="toggle" class="text-xs text-gray-700">Card view</label>
                            <div class="relative inline-block w-10 mr-2 align-middle select-none transition duration-200 ease-in">
                                <input wire:model="viewSwitch" type="checkbox" name="toggle" id="toggleView" value="card-view" class="toggle-checkbox2 absolute block w-6 h-6 rounded-full bg-white border-4 appearance-none cursor-pointer"/>
                                <label for="toggle" class="toggle-label2 block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                            </div>
                            <label for="toggle" class="text-xs text-gray-700">Table view</label>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <div wire:loading >
                                    <div class="fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-500 opacity-75 flex flex-col items-center justify-center">
                                        <div class="flex justify-center items-center">
                                            <div
                                                class="animate-spin rounded-full h-32 w-32 border-b-2 border-white-900"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <x-table.heading class="pr-0 w-8">
                                            <x-input.checkbox wire:model="selectPage" />
                                        </x-table.heading>

                                        @foreach($listColumns as $listColumn)
                                            @if (isset($columnPreference[$listColumn['column']]))
                                                @php
                                                    $column = $listColumn['column'];
                                                    $direction = $this->sortDirection($column);
                                                @endphp
                                                <x-table.heading sortable wire:click="sortBy('{{ $column }}')" :direction="$direction">{{ $listColumn['label'] }}</x-table.heading>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if ($selectPage)
                                        <x-table.row class="bg-cool-gray-200" wire:key="row-message">
                                            <x-table.cell colspan="7">
                                                @unless ($selectAll)
                                                    <div>
                                                        <span>You have selected <strong>{{ $cars->count() }}</strong> items, do you want to select all <strong>{{ $cars->total() }}</strong>?</span>
                                                        <x-button.link wire:click="selectAll" class="ml-1 text-blue-600">Select All</x-button.link>
                                                    </div>
                                                @else
                                                    <span>You are currently selecting all <strong>{{ $cars->total() }}</strong> items.</span>
                                                @endif
                                            </x-table.cell>
                                        </x-table.row>
                                    @endif
                                    @foreach ($cars as $car)
                                        <tr class="@if ($loop->even) bg-gray-50 @else bg-white @endif">
                                            <x-table.cell class="pr-0">
                                                <x-input.checkbox wire:model="selectedRows" value="{{ $car->manufacturer_id }}" />
                                            </x-table.cell>
                                            @foreach($listColumns as $listColumn)
                                                @if (isset($columnPreference[$listColumn['column']]))
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $car->{$listColumn['column']} }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <div class="">
                {{ $cars->links('frontend.pagination.tailwind') }}
            </div>
        </div>
    </div>
</div>
