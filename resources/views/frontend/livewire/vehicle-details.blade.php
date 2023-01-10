<div>
    <div class="py-10">
        <main>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div>
                    <div class="mx-auto py-4 px-4 sm:py-8 sm:px-6 lg:max-w-7xl lg:px-0 md:px-0">
                        <!-- Product -->
                        <div class="md:grid md:grid-rows-1 md:grid-cols-6 md:gap-x-2 md:gap-y-4 xl:gap-x-8">
                            <!-- Product image -->
                            <div class="md:row-end-1 md:col-span-6">
                                <div class="aspect-w-4 aspect-h-3 rounded-lg bg-gray-100 overflow-hidden">
                                    <img src="{{ $vehicle->getBannerImage() }}" alt="Not Found" onerror="this.src='{{url('/images/placeholder-car.png')}}'" class="object-center object-cover">
                                    <div class="flex items-end opacity-0 p-4 opacity-100" aria-hidden="true">
                                        <div class="absolute top-0 right-0 m-3 bg-white bg-opacity-75 hover:text-red-700 group-focus:text-yellow-300 backdrop-filter backdrop-blur py-2 px-4 rounded-md text-sm font-medium text-gray-900 text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product details -->
                            <div class="max-w-2xl mx-auto mt-14 sm:mt-16 md:max-w-none md:mt-0 md:row-end-2 md:row-span-2 md:col-span-3">
                                <div class="mt-4">
                                    <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">{{ $vehicle->firstRegistrationYear }} {{ $vehicle->getPropertyForDisplaying('brand') }} {{ $vehicle->getPropertyForDisplaying('model') }}</h1>
                                    <p class="text-base font-normal text-gray-400 mb-3 sm:text-xl">{{ $vehicle->getPropertyForDisplaying('version_description') }}</p>
                                </div>
                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
                                    <div class="flex flex-col-reverse">
                                        <div class="mt-4 md:text-left">
                                            <div class="relative">
                                                <div class="absolute flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-8">
                                                    <p class="text-gray-500 mt-2">{{ $vehicle->getPropertyForDisplaying('condition_type') }}</p>
                                                </div>
                                            </div>
                                            @if($vehicle->has_warranty)
                                                <div class="relative">
                                                    <div class="absolute flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" /></svg>
                                                    </div>
                                                    <div class="ml-8">
                                                        <p class="text-gray-500 mt-2">Warranty exists</p>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="relative">
                                                <div class="absolute flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-8">
                                                    <p class="text-gray-500 mt-2">Available</p>
                                                </div>
                                            </div>

                                            <div class="relative">
                                                <div class="absolute flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-8">
                                                    <p class="text-gray-500 mt-2">{{ $vehicle->firstRegistrationYearMonth }}</p>
                                                </div>
                                            </div>
                                            <div class="relative">
                                                <div class="absolute flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-8">
                                                    <p class="text-gray-500 mt-2">{{ $vehicle->getPropertyForDisplaying('km') }} km</p>
                                                </div>
                                            </div>

                                            <div class="relative">
                                                <div class="absolute flex">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                </div>
                                                <div class="ml-8">
                                                    <p class="text-gray-500 mt-2">{{ $vehicle->getPropertyForDisplaying('company') }}</p>
                                                </div>
                                            </div>

                                            <div class="relative">
                                                <div class="absolute flex">
                                                    <a href="#" class="font-medium text-custom-indigo hover:text-custom-indigo">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                        </svg>
                                                    </a>
                                                </div>
                                                <div class="ml-8">
                                                    <p class="text-gray-500 mt-2"><a href="#" class="font-medium text-custom-indigo hover:text-custom-indigo">More information</a></p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="overflow-y-auto h-48">
                                        @foreach($users as $user)
                                            <div>
                                                <div class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    <b>{{ $user->name }}</b>
                                                    <br>
                                                    <div class="mt-1">
                                                        <div class="flex">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                            </svg>
                                                            <p class="ml-5 text-sm leading-6 text-gray-500">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-1">
                                                        <div class="flex">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="mt-1 h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                            </svg>
                                                            <p class="ml-5 mb-2 text-sm leading-6 text-gray-500">{{ $user->telephone }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="flex flex-col-reverse">
                                    <div class="mt-4 md:text-left">
                                        <!-- Start pricing section b2b -->
                                        <section aria-labelledby="summary-heading" class="mt-16 bg-custom-grey rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                                            <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Vehicle Pricing</h2>
                                            <dl class="mt-6 space-y-4">
                                                <div class="flex items-center justify-between">
                                                    <div class="relative inline-flex">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-gray-600 mr-1">EURO Price</span>
                                                            <svg wire:click="$emit('showInfoModal', 'Price in Euro', 'Estimated price in Euro calculated from seller price using the middle exchange rate.')" class="clickable h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <dd class="text-base font-medium text-gray-900"> € {{ carmarket_price_display_format($vehicle->price_in_euro) }} </dd>
                                                </div>
                                                @if ($vehicle->hasNonEuroPrice())
                                                    <div class=" border-t border-gray-200 pt-4 flex items-center justify-between">
                                                        <div class="relative inline-flex">
                                                            <div class="flex items-center justify-between">
                                                                <span class="text-gray-600 mr-1">Seller Price</span>
                                                                <svg wire:click="$emit('showInfoModal', 'Seller Price', 'Price of the vehicle in local currency.')" class="clickable h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <dd class="text-sm font-medium text-gray-900"> {{ $vehicle->currency_iso_codification }} {{ carmarket_price_display_format($vehicle->b2b_price_ex_vat) }} </dd>
                                                    </div>
                                                @endif
                                                @if ($biddingPrice)
                                                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                                                        <div class="relative inline-flex">
                                                            <div class="flex items-center justify-between">
                                                                <span class="text-gray-600 mr-1">Projected price for you</span>
                                                                <svg wire:click="$emit('showCarBidderModal')" class="clickable h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <dd class="text-sm font-medium text-gray-900"> {{ $currency }} {{ carmarket_price_display_format($biddingPrice) }} </dd>
                                                    </div>
                                                @endif
                                            </dl>
                                        </section>
                                    </div>
                                </div>
                                <div class="mt-10 grid">
                                    <livewire:cart-button :vehicle="$vehicle" :fullWidth="true"/>
                                </div>
                                <div class="border-t border-gray-200 mt-10 pt-10">
                                    <h3 class="text-sm font-medium text-gray-900">Notes</h3>
                                    <div class="mt-4 prose prose-sm text-gray-500">
                                        <p>{{ $vehicle->note }}</p>
                                    </div>
                                </div>
                                <div class="border-t border-gray-200 mt-10 pt-10">
                                    <h3 class="text-sm font-medium text-gray-900">Documents</h3>
                                    <div class="sm:col-span-2">
                                        <dd class="mt-4 text-sm text-gray-900">
                                            <ul role="list" class="border border-gray-100 rounded-md divide-y divide-gray-200">
                                                @foreach($vehicle->getDocuments() as $document)
                                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                                        <div class="w-0 flex-1 flex items-center">
                                                            <!-- Heroicon name: solid/paper-clip -->
                                                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span class="ml-2 flex-1 w-0 truncate"> {{ $document }} </span>
                                                        </div>
                                                        <div class="ml-4 flex-shrink-0"> <a href="{{ $document }}" class="font-medium text-indigo-600 hover:text-indigo-500"> Download </a> </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </dd>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full max-w-2xl mx-auto mt-16 md:max-w-none md:mt-0 md:col-span-4">
                                <div x-data="{ tab: 'basic' }">
                                    <div class="border-b border-gray-200">
                                        <div class="-mb-px flex space-x-8" aria-orientation="horizontal" role="tablist">
                                            <!-- Selected: "border-indigo-600 text-indigo-600", Not Selected: "border-transparent text-gray-700 hover:text-gray-800 hover:border-gray-300" -->
                                            <button :class="{ 'border-indigo-600 text-indigo-600': tab === 'basic' }" @click.prevent="tab = 'basic'" id="tab-basicinfo" class="border-transparent text-gray-700 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap py-6 border-b-2 font-medium text-sm" aria-controls="tab-panel-basicinfo" role="tab" type="button">
                                                Basic Information
                                            </button>
                                            <button :class="{ 'border-indigo-600 text-indigo-600': tab === 'equipment' }" @click.prevent="tab = 'equipment'" id="tab-options" class="border-transparent text-gray-700 hover:text-gray-800 hover:border-gray-300 whitespace-nowrap py-6 border-b-2 font-medium text-sm" aria-controls="tab-panel-options" role="tab" type="button">
                                                Equipment / Additional Options
                                            </button>
                                        </div>
                                    </div>

                                    <!-- 'Basic Information' panel, show/hide based on tab state -->
                                    <div id="tab-panel-basicinfo" class="-mb-10 mt-10" aria-labelledby="tab-basicinfo" role="tabpanel" tabindex="0" x-show="tab === 'basic'">
                                        <h3 class="sr-only">Basic Information</h3>
                                        <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                                            <div>
                                                <dt>
                                                    <div class="flex items-center">
                                                        <!-- Heroicon name: outline/globe-alt -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                                        </svg>
                                                        <p class="ml-2 text-base leading-6 font-semibold text-custom-gray">Characteristics</p>
                                                    </div>
                                                </dt>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('condition_type') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('vehicle_type') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('body_type') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('seats') }} Seats
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('doors') }} Doors
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('km') }} km
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    1<sup>st</sup> reg: {{ $vehicle->firstRegistrationYearMonth }}
                                                </dd>
                                            </div>

                                            <div>
                                                <dt>
                                                    <div class="flex items-center">
                                                        <!-- Heroicon name: outline/globe-alt -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        <p class="ml-2 text-base leading-6 font-semibold text-custom-gray">Engine &amp; Drive</p>
                                                    </div>
                                                </dt>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('fuel_type') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('gearbox') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('cylinders') }} Cylinders
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('hp') }} HP
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('kw') }} 104
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('cm3') }} ccm<sup>2</sup>
                                                </dd>
                                                <dd class="ml-8 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('drive_type') }}
                                                </dd>
                                            </div>

                                            <div>
                                                <dt>
                                                    <div class="flex items-center">
                                                        <!-- Heroicon name: outline/globe-alt -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                                                        </svg>
                                                        <p class="ml-2 text-base leading-6 font-semibold text-custom-gray">Colors</p>
                                                    </div>
                                                </dt>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    Exterior: {{ $vehicle->getPropertyForDisplaying('color_description') }} ({{ $vehicle->getPropertyForDisplaying('color_code') }})
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    Interior: n/a
                                                </dd>
                                            </div>

                                            <div>
                                                <dt>
                                                    <div class="flex items-center">
                                                        <!-- Heroicon name: outline/globe-alt -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                                        </svg>
                                                        <p class="ml-2 text-base leading-6 font-semibold text-custom-gray">Environment &amp; Engine data</p>
                                                    </div>
                                                </dt>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('fuel_consumption_total') }} / 100km Total (Fuel Consumption Total)
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('fuel_consumption_land') }} / 100km Total (Fuel Consumption Land)
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('fuel_consumption_city') }} / 100km Total (Fuel Consumption City)
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('fuel_consumption_rating') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('pollution_norm') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    C0<sub>2</sub>-Emmission: {{ $vehicle->getPropertyForDisplaying('co2') }} g/km
                                                </dd>
                                            </div>

                                            <div>
                                                <dt>
                                                    <div class="flex items-center">
                                                        <!-- Heroicon name: outline/globe-alt -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                                        </svg>
                                                        <p class="ml-2 text-base leading-6 font-semibold text-custom-gray">Weight</p>
                                                    </div>
                                                </dt>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    {{ $vehicle->getPropertyForDisplaying('weight') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    2’000 kg Towing weight (not yet)
                                                </dd>
                                            </div>

                                            <div>
                                                <dt>
                                                    <div class="flex items-center">
                                                        <!-- Heroicon name: outline/globe-alt -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path>
                                                        </svg>
                                                        <p class="ml-2 text-base leading-6 font-semibold text-custom-gray">Identifiers</p>
                                                    </div>
                                                </dt>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    VIN: {{ $vehicle->getPropertyForDisplaying('manufacturer_id') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    SKU: {{ $vehicle->getPropertyForDisplaying('sku_number') }}
                                                </dd>
                                                <dd class="ml-8 mb-0.5 text-sm text-gray-900">
                                                    Cerfificate: {{ $vehicle->getPropertyForDisplaying('certification_code') }}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>

                                    <!-- 'Equipment / Additional Options' panel, show/hide based on tab state -->
                                    <div id="tab-panel-options" class="pt-10" aria-labelledby="tab-options" role="tabpanel" tabindex="0" x-show="tab === 'equipment'">
                                        <h3 class="sr-only">Equipment / Additional Options</h3>
                                        <div class="prose prose-sm max-w-none text-gray-500">
                                            <h4>Equipment</h4>
                                            <ul role="list">
                                                @foreach(format_equipment($vehicle->option_code_description) as $equipmentItem)
                                                    <li>{{ $equipmentItem }} </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<livewire:info-modal/>
