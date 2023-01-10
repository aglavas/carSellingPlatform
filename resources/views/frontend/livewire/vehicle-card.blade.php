<div class="relative group">
    <div class="aspect-w-4 aspect-h-3 rounded-lg overflow-hidden bg-gray-100">
        <img src="{{ static_image_carmarket($vehicle->getBannerImage()) }}" alt="Not Found" onerror="this.src='{{url('/images/placeholder-car.png')}}'" class="object-center object-cover @if ($selected) opacity-25 @endif" loading="lazy">
        <div class="flex items-end opacity-0 p-4 opacity-100" aria-hidden="true">
            <div class="absolute top-0 left-0 m-2 py-2 px-2 text-sm font-medium text-gray-900 text-center">
            @if($inCart)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">In Cart</span>
            @elseif($inEnquiry)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">In Enquiry</span>
            @elseif($denied)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Previously Denied</span>
            @else

            @endif
            </div>
            @if($inCart)
                <div x-data="{ hoverCart: false }">
                    <div wire:click="removeFromCart" wire:loading.attr="disabled" x-on:mouseenter="hoverCart = true" x-on:mouseleave="hoverCart = false" class="absolute top-0 right-12 py-1 px-2 mt-3 mr-4 bg-white bg-opacity-75 backdrop-filter backdrop-blur rounded-md text-sm font-medium text-gray-900 text-center z-10 clickable">
                        <svg x-show="!hoverCart" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <svg x-show="hoverCart" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            @elseif($inEnquiry)
                <div class="absolute top-0 right-12 py-1 px-2 mt-3 mr-4 bg-white bg-opacity-75 backdrop-filter backdrop-blur rounded-md text-sm font-medium text-gray-900 text-center z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            @else
                <div x-data="{ hoverCart: false }">
                    <div wire:click="addToCart" wire:loading.attr="disabled" x-on:mouseenter="hoverCart = true" x-on:mouseleave="hoverCart = false" class="absolute top-0 right-12 py-1 px-2 mt-3 mr-4 bg-white bg-opacity-75 backdrop-filter backdrop-blur rounded-md text-sm font-medium text-gray-900 text-center z-10 clickable">
                        <svg x-show="!hoverCart" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <svg x-show="hoverCart" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            @endif
            @if ($selected)
                <div x-data="{ hoverSelect: false }">
                    <div wire:click="unSelect('{{ $vehicle->manufacturer_id }}')" x-on:mouseenter="hoverSelect = true" x-on:mouseleave="hoverSelect = false"  class="absolute top-0 right-0 py-1 px-2 mt-3 mr-4 hover:text-red-700 group-focus:text-red-700 bg-white bg-opacity-75 backdrop-filter backdrop-blur rounded-md text-sm font-medium text-gray-900 text-center z-10 clickable">
                        <svg x-show="!hoverSelect" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 4a2 2 0 012-2h6a2 2 0 012 2v14l-5-2.5L5 18V4z" />
                        </svg>
                        <svg x-show="hoverSelect" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>
            @else
                <div x-data="{ hoverSelect: false }">
                    <div wire:click="select('{{ $vehicle->manufacturer_id }}')" class="absolute top-0 right-0 py-1 px-2 mt-3 mr-4 hover:text-green-700 group-focus:text-green-700 bg-white bg-opacity-75 backdrop-filter backdrop-blur rounded-md text-sm font-medium text-gray-900 text-center z-10 clickable">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                    </div>
                </div>
            @endif
        </div>
        @if (!$selected)
            <div class="flex items-end opacity-0 p-4 group-hover:opacity-100">
                <div class="w-full bg-white bg-opacity-75 backdrop-filter backdrop-blur py-2 px-4 rounded-md text-sm font-medium text-gray-900 text-center z-10 clickable" wire:click="previewVehicle('{{ $vehicle->manufacturer_id }}')">
                    Quickpreview
                </div>
            </div>
        @endif
    </div>
    <div class="mt-4 flex items-center justify-between text-base font-extrabold text-gray-900 space-x-8">
        <h3>
            <a href="#">
                <span aria-hidden="true" class="absolute inset-0"></span>
                {{ $vehicle->firstRegistrationYear }} {{ $vehicle->brand }} {{ $vehicle->model }}
            </a>
        </h3>
    </div>
    <div class="mt-1 flex items-center justify-between text-sm font-normal text-gray-400 space-x-8">
        <p>
            <span aria-hidden="true" class="absolute inset-0"></span>
            {{ $vehicle->version_description }}
            <br>
            <span aria-hidden="true" class="absolute inset-0"></span>
            {{ $vehicle->km }} km
        </p>
    </div>
    <div class="mt-4 flex items-center justify-between text-base font-normal text-gray-400 space-x-8">
        @if ($vehicle->isVatDeductible())
            <p>VAT deductible</p>
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 noVatColor" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path>
            </svg>No VAT
        @endif
        <h3 class="font-extrabold text-gray-900 text-right">
            <span aria-hidden="true" onclick="location='{{ route('vehicle.details', ['vehicle' => $vehicle->manufacturer_id]) }}'" class="absolute inset-0 clickable"></span>
            € {{ carmarket_price_display_format($vehicle->price_in_euro) }}
        </h3>
    </div>
</div>
