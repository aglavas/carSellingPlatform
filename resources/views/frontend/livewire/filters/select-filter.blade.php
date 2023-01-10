<div x-data="{ {{ $column }}: false, timeout: false  }">
    <div class="border-t border-gray-200 px-4 py-6">
        <div x-on:click="{{ $column }} = !{{ $column }}"  class="-mx-2 -my-3 flow-root clickable" style="display: inline-block; width: 100%;">
             <span class="font-medium text-gray-900" style="float: left">
                 {{ $label }}
             </span>
             <span class="ml-6 flex items-center" style="float: right">
                 <svg x-show="!{{ $column }}" class="h-5 w-5 clickable" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                   <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                 <svg x-show="{{ $column }}" class="h-5 w-5 clickable" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                   <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
             </span>
        </div>
        <!-- Filter section, show/hide based on section state. -->
        <div x-show="{{ $column }}"
             class="pt-6"
             id="filter-section-mobile-0"
        >
            <div class="w-full {{ $this->getHeight($options) }}">
                <div class="space-y-6" x-on:click="clearTimeout(timeout); timeout = setTimeout(() => $wire.call('$refresh'), 1500);">
                    @foreach($options as $key => $item)
                        <div class="flex items-center">
                                @if (in_array($item, $selected))
                                    <label class="ml-3 min-w-0 flex-1 text-gray-500 clickable">
                                        <input wire:model.defer="selected" value="{{$item}}" type="checkbox" class="h-4 w-4 mr-2 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500 clickable" data-np-checked="1" checked>
                                        {{ ($labelBy ? $labelBy::resolve($item) : $item) }}
                                    </label>
                                @else
                                    <label class="ml-3 min-w-0 flex-1 text-gray-500 clickable">
                                        <input wire:model.defer="selected" value="{{$item}}" type="checkbox" class="h-4 w-4 mr-2 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500 clickable" data-np-checked="1">
                                        {{ ($labelBy ? $labelBy::resolve($item) : $item) }}
                                    </label>
                                @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
