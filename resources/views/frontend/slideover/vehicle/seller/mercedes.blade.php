{{--<div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">--}}
    {{--<div class="min-h-0 flex-1 flex flex-col overflow-y-scroll">--}}
        {{--<div class="py-6 px-4 bg-blue-700 sm:px-6">--}}
            {{--<div class="flex items-center justify-between">--}}
                {{--<h2 id="slide-over-heading" class="text-lg font-medium text-white">--}}
                    {{--{{ $vehicle->brand->name }} {{ $vehicle->model_name }} {{ $vehicle->version }}--}}
                {{--</h2>--}}
                {{--<div class="ml-3 h-7 flex items-center">--}}
                    {{--<button @click="$wire.closeSlideOver()" class="bg-blue-700 rounded-md text-blue-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">--}}
                        {{--<span class="sr-only">Close panel</span>--}}
                        {{--<!-- Heroicon name: outline/x -->--}}
                        {{--<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">--}}
                            {{--<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />--}}
                        {{--</svg>--}}
                    {{--</button>--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="mt-1">--}}
                {{--<p class="text-sm text-blue-300">--}}
                    {{--{{ $vehicle->company }}, {{ convert_iso3166_to_country($vehicle->country) }}--}}
                {{--</p>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="mt-6 relative flex-1 px-4 sm:px-6">--}}
            {{--<x-data-list>--}}
                {{--<x-data-list-item label="An" value="{{ $vehicle->an }}"/>--}}
                {{--<x-data-list-item label="Bm" value="{{ $vehicle->bm }}"/>--}}
                {{--<x-data-list-item label="Color" value="{{ $vehicle->color }}"/>--}}
                {{--<x-data-list-item label="Interior" value="{{ $vehicle->interior }}"/>--}}
                {{--<x-data-list-item label="Upholstery" value="{{ $vehicle->upholstery }}"/>--}}
                {{--<x-data-list-item label="Options" value="{{ $vehicle->options }}"/>--}}
                {{--<x-data-list-item label="Vin" value="{{ $vehicle->vin }}"/>--}}
                {{--<x-data-list-item label="Brand" value="{{ $vehicle->brand->name }}"/>--}}
                {{--<x-data-list-item label="Model" value="{{ $vehicle->model }}"/>--}}
            {{--</x-data-list>--}}
        {{--</div>--}}
        {{--<div class="mt-6 relative flex-1 px-4 sm:px-6">--}}
            {{--<div class="pb-5 border-b border-gray-200">--}}
                {{--<h3 class="text-lg leading-6 font-medium text-gray-900">--}}
                    {{--Contacts--}}
                {{--</h3>--}}
            {{--</div>--}}
            {{--<x-contact-list :users="get_contacts_of_new_car($vehicle->country, $vehicle->brand_id)" />--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="flex-shrink-0 px-4 py-4 flex justify-end">--}}
        {{--<button wire:click="$emit('closeSlideOver')" type="button"--}}
                {{--class="mx-2 bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">--}}
            {{--Cancel--}}
        {{--</button>--}}
        {{--<livewire:cart-button :vehicle="$vehicle"/>--}}
        {{-- WISHLIST <livewire:wishlist :vehicle="$vehicle"/> --}}
    {{--</div>--}}
{{--</div>--}}
