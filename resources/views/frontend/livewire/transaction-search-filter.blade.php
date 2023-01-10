<div
    class="fixed inset-0 overflow-hidden z-10 w-96"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true"
    x-data="{ open: false }"
    x-show="open"
    @open-dropdown.window="if ($event.detail.id == 5) open = true"
    @click.away="open = false"
>
    <div class="absolute inset-0 overflow-hidden">
        <!-- Background overlay, show/hide based on slide-over state. -->
        <div class="absolute inset-0" aria-hidden="true">
            <div class="fixed inset-y-0 left-0 pr-10 max-w-full flex top-36">
                <div x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-md">
                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                        <div class="px-4 sm:px-6">
                            <div class="flex items-start justify-between">
                                <h2 class="text-lg font-semibold text-gray-900" id="slide-over-title">
                                    Filter
                                </h2>
                                <div class="ml-3 h-7 flex items-center">
                                    <button type="button" @click="open = false" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">Close panel</span>
                                        <!-- Heroicon name: outline/x -->
                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 relative flex-1 px-4 sm:px-6">
                            <form class="mt-4 border-t border-gray-200">
                                @foreach($filters as $key => $filter)
                                    @if($filter['type'] === 'single')
                                        @if(isset($filter['labelBy']))
                                            <livewire:filters.select-filter :transactionType="$transactionType" :listType="$listType" :resourceClass="$resourceClass" column="{{ $key }}" label="{{ format_filter_label($key) }}" key="{{ rand() }}" labelBy="{{ $filter['labelBy'] }}"/>
                                        @else
                                            <livewire:filters.select-filter :transactionType="$transactionType" :listType="$listType" :resourceClass="$resourceClass" column="{{ $key }}" label="{{ format_filter_label($key) }}" key="{{ rand() }}" />
                                        @endif
                                    @elseif ($filter['type'] === 'max')
                                        <livewire:filters.max-filter :resource="$resource" column="{{ $filter['column'] }}" label="{{ format_filter_label($key) }}" filter="{{ $key }}" key="{{ rand() }}"/>
                                    @endif
                                @endforeach
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



