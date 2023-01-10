<div>
    <div
        x-data="{ isOpen: false }">
        <button @click="isOpen = !isOpen" type="button" aria-haspopup="listbox" aria-expanded="true"
                aria-labelledby="listbox-label"
                class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
        >
            <span class="block truncate">
            Columns
            </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                     aria-hidden="true">
                  <path fill-rule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clip-rule="evenodd"/>
                </svg>
            </span>
        </button>
        <div class="absolute mt-1 rounded-md bg-white shadow-lg z-10" x-show="isOpen"
             @click.away="isOpen = false"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"

        >
            <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-item-3"
                class="grid grid-cols-2 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                @foreach($columnList as $column)
                    <li wire:key="{{ $column['column'] }}" role="option"
                        class="text-gray-900 cursor-default select-none relative hover:text-white hover:bg-blue-600">
                        <label for="column-preference-{{ $column['column'] }}" class="font-medium py-2 px-4 block">

                                @if (isset($selectedColumns[$column['column']]) && ($selectedColumns[$column['column']] === true))
                                    <input id="column-preference-{{ $column['column'] }}" name="{{ $column['column'] }}" type="checkbox" checked wire:model="selectedColumns.{{ $column['column'] }}" class="focus:ring-blue-500 h-4 w-4 mr-2 text-blue-600 border-gray-300 rounded">
                                @else
                                    <input id="column-preference-{{ $column['column'] }}" name="{{ $column['column'] }}" type="checkbox" wire:model="selectedColumns.{{ $column['column'] }}" class="focus:ring-blue-500 h-4 w-4 mr-2 text-blue-600 border-gray-300 rounded">
                                @endif
                                    {{ $column['label'] }}
                        </label>
                    </li>
                @endforeach
            </ul>
            <button wire:click="saveColumnPreferences" class="w-full items-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Save
            </button>
        </div>
    </div>
</div>
