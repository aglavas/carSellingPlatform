<div x-data="{ transaction_status: false }">
    <div class="border-t border-gray-200 px-4 py-6">
        <div x-on:click="transaction_status = !transaction_status" class="-mx-2 -my-3 flow-root clickable" style="display: inline-block; width: 100%;">
            <span class="font-medium text-gray-900" style="float: left">
                 Transaction Status
            </span>
            <span class="ml-6 flex items-center" style="float: right">
                <svg x-show="!transaction_status" class="h-5 w-5 clickable" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                   <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                </svg>
                <svg x-show="transaction_status" class="h-5 w-5 clickable" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                   <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                </svg>
             </span>
        </div>
        <!-- Filter section, show/hide based on section state. -->
        <div x-show="transaction_status"
             class="pt-6"
             id="filter-section-mobile-0"
        >
            <div class="space-y-6">
                @foreach($options as $key => $item)
                    <div class="flex items-center clickable" wire:click="apply('{{ $key }}')" wire:key="'{{$key}}'">
                        {{--<div  class="clickable">--}}
                            @if ($key === $status)
                                <input value="white" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500 clickable" data-np-checked="1" checked>
                            @else
                                <input value="white" type="checkbox" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500 clickable" data-np-checked="1">
                            @endif
                            <label class="ml-3 min-w-0 flex-1 text-gray-500 clickable">
                                {{ $item }}
                            </label>
                        {{--<div>--}}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
