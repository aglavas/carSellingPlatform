{{--<div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">--}}
    {{--<div class="min-h-0 flex-1 flex flex-col overflow-y-scroll">--}}
        {{--<div class="py-6 px-4 bg-blue-700 sm:px-6">--}}
            {{--<div class="flex items-center justify-between">--}}
                {{--<h2 id="slide-over-heading" class="text-lg font-medium text-white">--}}
                    {{--{{ $vehicle->brand }} {{ $vehicle->model }}--}}
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
        {{--<div class="splide">--}}
            {{--<div class="splide__track">--}}
                {{--<ul class="splide__list">--}}
                    {{--@foreach($vehicle->image as $img)--}}
                        {{--<li class="splide__slide">--}}
                            {{--<img src="{{ $img }}" alt="">--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="mt-6 relative flex-1 px-4 sm:px-6">--}}
            {{--<x-data-list>--}}
                {{--<x-data-list-item label="Engine" value="{{ $vehicle->engine }}"/>--}}
                {{--<x-data-list-item label="Fuel Type" value="{{ $vehicle->fuel_type }}"/>--}}
                {{--<x-data-list-item label="Gearbox" value="{{ $vehicle->gearbox }}"/>--}}
                {{--<x-data-list-item label="Km" value="{{ $vehicle->km }}"/>--}}
                {{--<x-data-list-item label="First Registration" value="{{ $vehicle->firstregistration }}"/>--}}
                {{--<x-data-list-item label="First Registration Year"--}}
                                  {{--value="{{ (is_null($vehicle->firstregistration) ? '' : $vehicle->firstregistration->format('Y')) }}"/>--}}
                {{--<x-data-list-item label="Color Code" value="{{ $vehicle->color_code }}"/>--}}
                {{--<x-data-list-item label="Color Description" value="{{ $vehicle->color_description }}"/>--}}
                {{--<x-data-list-item label="Option Code Description" value="{{ $vehicle->option_code_description }}"/>--}}
                {{--<x-data-list-item label="Option Code Description English"--}}
                                  {{--value="{{ $vehicle->option_code_description_english }}"/>--}}
                {{--<x-data-list-item label="Currency" value="{{ $vehicle->currency_iso_codification }}"/>--}}
                {{--<x-data-list-item label="B2B Price Excl. Vat" value="{{ $vehicle->b2b_price_ex_vat }}"/>--}}
                {{--<x-data-list-item label="Price in Euro (Approx.)" value="{{ $vehicle->price_in_euro }}"/>--}}
                {{--<x-data-list-item label="VAT Deductible?" value="{{ $vehicle->vat_deductible }}"/>--}}
                {{--<x-data-list-item label="Damages Excl. Vat" value="{{ $vehicle->damages_excl_vat }}"/>--}}
                {{--<x-data-list-item label="VpVu" value="{{ $vehicle->vpvu }}"/>--}}
                {{--<x-data-list-item label="Origin" value="{{ $vehicle->origin }}"/>--}}
                {{--<x-data-list-item label="Disponibility" value="{{ $vehicle->disponibility }}"/>--}}
                {{--<x-data-list-item label="Loading Place"--}}
                                  {{--value="{{ (is_null($vehicle->disponibility) ? '️✔️' : $vehicle->disponibility->format('Y-m-d')) }}"/>--}}
                {{--<x-data-list-item label="Co2" value="{{ $vehicle->co2 }}"/>--}}
                {{--<x-data-list-item label="Language" value="{{ $vehicle->language_option_code_description }}"/>--}}
                {{--@if ($vehicle->url_address)--}}
                    {{--<x-data-list-item label="Url Address" value="{{ $vehicle->url_address }}" :link="true"/>--}}
                {{--@else--}}
                    {{--<x-data-list-item label="Url Address" value=""/>--}}
                {{--@endif--}}
                {{--<x-data-list-item label="Country" value="{{ convert_iso3166_to_country($vehicle->country) ?? '' }}"/>--}}
                {{--<x-data-list-item label="Company" value="{{ $vehicle->company ?? '' }}"/>--}}
                {{--<x-data-list-item label="Created At" value="{{ $vehicle->created_at }}"/>--}}
                {{--<x-data-list-item label="Exchange Rate" value="Extract to property"/>--}}
            {{--</x-data-list>--}}
        {{--</div>--}}
        {{--<div class="mt-6 relative flex-1 px-4 sm:px-6">--}}
            {{--<div class="pb-5 border-b border-gray-200">--}}
                {{--<h3 class="text-lg leading-6 font-medium text-gray-900">--}}
                    {{--Contacts--}}
                {{--</h3>--}}
            {{--</div>--}}
            {{--<x-contact-list :users="get_enquiry_contacts_for_used_cars($vehicle)" />--}}
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
{{--<script>--}}
    {{--@if(count($vehicle->image))--}}
        {{--new Splide( '.splide', {--}}
            {{--height: "30vh"--}}
        {{--} ).mount();--}}
    {{--@endif--}}
{{--</script>--}}
