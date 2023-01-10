<div>
    <div class="py-10">
        <header>
            <div class="max-w-2xl mx-auto sm:px-6 lg:max-w-7xl lg:px-8">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">My Enquiry</h1>
            </div>
        </header>
        <main>
            @if(count($vehicleCollection) > 0)
                <div class="bg-white">
                    <div class="max-w-2xl mx-auto pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                        <form class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16" method="POST" action="{{ route('enquiry.store') }}">
                            @csrf
                            <section aria-labelledby="cart-heading" class="lg:col-span-7">
                                <h2 id="cart-heading" class="sr-only">Vehicles in your cart</h2>
                                <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                                    @foreach($displayCollection as $company => $companyVehicleCollection)
                                        <div class="bg-gray-50 rounded-lg lg:p-8 lg:mt-0">
                                            <b>{{ $company }}</b>
                                        @foreach($companyVehicleCollection as $vehicle)
                                            <li class="flex py-6 sm:py-10">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $vehicle->getBannerImage() }}" alt="Not Found" onerror="this.src='{{url('/images/placeholder-car.png')}}'" class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48">
                                                </div>
                                                <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                                                    <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                                        <div>
                                                            <div class="flex justify-between">
                                                                <h3 class="text-sm">
                                                                    <a href="{{ route('vehicle.details', ['vehicle' => $vehicle->manufacturer_id]) }}" class="font-medium text-gray-700 hover:text-gray-800">
                                                                        {{ $vehicle->firstRegistrationYear }} {{ $vehicle->brand }} {{ $vehicle->model }}
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                            <div class="mt-1 flex text-sm">
                                                                <p class="text-gray-500">
                                                                    {{ $vehicle->version_description }}
                                                                </p>
                                                            </div>
                                                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $vehicle->km }} km</p>
                                                            <p class="mt-1 text-sm font-medium text-gray-900">€ {{ carmarket_price_display_format($vehicle->price_in_euro) }}</p>
                                                        </div>

                                                        <div class="mt-4 sm:mt-0 sm:pr-9">
                                                            <label for="quantity-0" class="sr-only">Quantity, Basic Tee</label>
                                                            <div class="absolute top-0 right-0">
                                                                <button wire:click="removeFromCart('{{ $vehicle->manufacturer_id }}')" type="button" class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500">
                                                                    <span class="sr-only">Remove</span>
                                                                    <!-- Heroicon name: solid/x -->
                                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if ($vehicle->hasDisponsibility())
                                                        <p class="mt-4 flex text-sm text-gray-700 space-x-2">
                                                            <!-- Heroicon name: solid/check -->
                                                            <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                            <span>Available</span>

                                                            @if ($vehicle->has_warranty)
                                                                <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                                </svg>
                                                                <span>With warranty</span>
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                            </li>
                                            @if(!$loop->last)
                                                <hr>
                                            @endif
                                        @endforeach
                                        </div>
                                    @endforeach
                                </ul>
                            </section>

                            <!-- Order summary -->
                            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Cart summary</h2>

                                <dl class="mt-6 space-y-4">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-sm text-gray-600">
                                            Total vehicles
                                        </dt>
                                        <dd class="text-sm font-medium text-gray-900">
                                            {{ count($vehicleCollection) }}
                                        </dd>
                                    </div>
                                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                                        <dt class="text-base font-medium text-gray-900">
                                            Inquiry total
                                        </dt>
                                        <dd class="text-base font-medium text-gray-900">
                                            € {{ carmarket_price_display_format($this->totalPrice) }}
                                        </dd>
                                    </div>
                                </dl>

                                <div class="mt-6">
                                    <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Start inqury</button>
                                </div>
                            </section>
                        </form>
                    </div>
                </div>
            @else
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="px-4 py-8 sm:px-0">
                        <div class="bg-gray-50-custom sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Your cart is empty.</h3>
                                <div class="mt-2 max-w-xl text-sm leading-5 text-gray-500">
                                    <p>Buy a car now!</p>
                                </div>
                                <div class="mt-5">
                                  <span class="inline-flex rounded-md shadow-sm">
                                    <a class="button inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50 transition ease-in-out duration-150" type="button" href="{{ route('vehicle-search', ['type' => 'all']) }}">Go to Vehicles</a>
                                  </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>
</div>
