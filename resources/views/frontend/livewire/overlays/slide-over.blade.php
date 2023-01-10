<div>
    @if($vehicle)
        <div>
            <div class="py-10">
                <main>
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="fixed z-20 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
                            <div class="flex min-h-screen text-center md:block md:px-2 lg:px-4" style="font-size: 0;">
                                <div class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity md:block" aria-hidden="true"></div>
                                <span class="hidden md:inline-block md:align-middle md:h-screen" aria-hidden="true">​</span>
                                <div x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="ease-in duration-200"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                    class="flex text-base text-left transform transition w-full md:inline-block md:max-w-2xl md:px-4 md:my-8 md:align-middle lg:max-w-4xl"
                                >
                                    <div class="w-full relative flex items-center bg-white px-4 pt-14 pb-8 overflow-hidden shadow-2xl sm:px-6 sm:pt-8 md:p-6 lg:p-8">
                                        <button wire:click="closeSlideOver" type="button" class="absolute top-4 right-4 text-gray-400 hover:text-gray-500 sm:top-8 sm:right-6 md:top-6 md:right-6 lg:top-8 lg:right-8">
                                            <span class="sr-only">Close</span>
                                            <!-- Heroicon name: outline/x -->
                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <div class="w-full grid grid-cols-1 gap-y-8 gap-x-6 items-start sm:grid-cols-12 lg:gap-x-8">
                                            <div class="sm:col-span-4 lg:col-span-5">
                                                <div class="aspect-w-4 aspect-h-3 rounded-lg bg-gray-100 overflow-hidden">
                                                    <img class="object-center object-cover" src="{{ $vehicle->getBannerImage() }}" alt="Not Found" onerror="this.src='{{url('/images/placeholder-car.png')}}'">
                                                </div>
                                            </div>
                                            <div class="sm:col-span-8 lg:col-span-7">
                                                <h2 class="text-2xl font-extrabold text-gray-900 sm:pr-12">{{ $vehicle->brand }} {{ $vehicle->model }}</h2>
                                                <p class="text-xl font-normal text-gray-400 mb-3 sm:text-xl">{{ $vehicle->version_description }}</p>

                                                <section aria-labelledby="information-heading" class="mt-3">
                                                    <h3 class="text-xl font-bold tracking-tight text-gray-900 sm:text-xl">€ {{ carmarket_price_display_format($vehicle->price_in_euro) }}</h3>
                                                    <!-- Reviews -->

                                                    <div class="mt-6">
                                                        <p class="text-sm text-gray-500">
                                                            {{ $vehicle->note }}
                                                        </p>
                                                    </div>
                                                </section>
                                                <section aria-labelledby="options-heading" class="mt-6">
                                                    <h3 id="options-heading" class="sr-only">Product options</h3>
                                                    <div class="font-medium text-sm text-gray-900">
                                                        <div class="w-6/6 flex flex-wrap">
                                                            <div class="flex w-3/6 md:w-3/6 py-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                          d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                                    </path>
                                                                </svg>{{ $vehicle->getPropertyForDisplaying('condition_type') }}
                                                            </div>
                                                            @if($vehicle->has_warranty)
                                                                <div class="flex w-3/6 md:w-3/6 py-3">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                              d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                                                                        </path>
                                                                    </svg>With warranty
                                                                </div>
                                                            @endif
                                                            <div class="flex w-3/6 md:w-3/6 py-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>Available
                                                            </div>
                                                            <div class="flex w-3/6 md:w-3/6 py-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>{{ $vehicle->firstRegistrationYearMonth }}
                                                            </div>
                                                            <div class="flex w-3/6 md:w-3/6 py-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                                                </svg>{{ $vehicle->getPropertyForDisplaying('km') }} km
                                                            </div>
                                                            <div class="flex w-3/6 md:w-3/6 py-3">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                                </svg>{{ $vehicle->getPropertyForDisplaying('company') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mt-6 flex flex-wrap">
                                                        <livewire:cart-button :vehicle="$vehicle" :fullWidth="true"/>
                                                    </div>
                                                    <p class="w-full flex flex-wrap absolute top-4 justify-center text-center sm:static sm:mt-6">
                                                        <a href="{{ route('vehicle.details', ['vehicle' => $vehicle->manufacturer_id]) }}" class="font-medium text-custom-indigo hover:text-custom-indigo">View full details</a>
                                                    </p>
                                                </section>
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
    @endif
</div>
