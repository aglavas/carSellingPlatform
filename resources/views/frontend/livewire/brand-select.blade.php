<div>
    <div class="mt-1 relative" x-data="{ isOpen: false}">
        <button @click="isOpen = !isOpen" type="button" aria-haspopup="listbox" aria-expanded="true" aria-labelledby="listbox-label"
                class="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
      <span class="block truncate">
        Brands
      </span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
        <!-- Heroicon name: selector -->
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
             aria-hidden="true">
          <path fill-rule="evenodd"
                d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                clip-rule="evenodd"/>
        </svg>
      </span>
        </button>

        <!--
          Select popover, show/hide based on select state.

          Entering: ""
            From: ""
            To: ""
          Leaving: "transition ease-in duration-100"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="absolute mt-1 w-full rounded-md bg-white shadow-lg z-10" x-show="isOpen" @click.away="isOpen = false">
            <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-item-3"
                class="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm">
                <!--
                  Select option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

                  Highlighted: "text-white bg-blue-600", Not Highlighted: "text-gray-900"
                -->
                @foreach($options as $item)
                    @if(array_search($item, $selected) === false)
                    <li wire:click="toggle('{{ $item }}')" wire:key="'{{$item}}'" role="option"
                        class="text-gray-900 cursor-default select-none relative py-2 pl-8 pr-4">
                        <!-- Selected: "font-semibold", Not Selected: "font-normal" -->
                        <span class="font-normal block truncate">
            {{ $item }}
          </span>

                    </li>
                    @endif
                @endforeach


                <!-- More options... -->
            </ul>
        </div>
    </div>
</div>
