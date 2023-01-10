<div>
    <div class="bg-white">
        <div class="max-w-2xl mx-auto pt-16 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="px-4 space-y-2 sm:px-0 sm:flex sm:items-baseline sm:justify-between sm:space-y-0">
                <div class="flex sm:items-baseline sm:space-x-4">
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">Summary - Inquiry #54879</h1>
                </div>
                <p class="text-sm text-gray-600">Inquiry placed <time datetime="2021-03-22" class="font-medium text-gray-900">{{ $enquiry->created_at->format('Y-m-d') }}</time></p>
            </div>
            <!-- Products -->
            <div class="mt-6">
                <h2 class="sr-only">Vehicles requested</h2>
                <div class="space-y-8">
                    <table class="mt-4 w-full text-gray-500 sm:mt-6">
                        <caption class="sr-only">
                            Vehicles
                        </caption>
                        <thead class="sr-only text-sm text-gray-500 text-left sm:not-sr-only">
                            <tr>
                                <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">Vehicle</th>
                                <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">Price</th>
                                <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">Seller</th>
                            </tr>
                        </thead>
                        <tbody class="border-b border-gray-200 divide-y divide-gray-200 text-sm sm:border-t">
                        @foreach($enquiryItems as $vehicle)
                            <tr>
                                <td class="py-6 pr-8">
                                    <div class="flex items-center">
                                        <img src="{{url('/images/logos/' . Illuminate\Support\Str::snake(strtolower($vehicle->brand)) . '.svg')}}" class="w-16 h-16 object-center object-cover rounded mr-6">
                                        <div>
                                            <div class="font-medium text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"> {{ $vehicle->getPropertyForDisplaying('condition_type') }} </span>
                                                <a href="#">{{ $vehicle->getPropertyForDisplaying('brand') }} {{ $vehicle->getPropertyForDisplaying('model') }} {{ $vehicle->getPropertyForDisplaying('version_description') }}</a>
                                            </div>
                                            <div class="font-medium text-gray-900">{{ $vehicle->getPropertyForDisplaying('manufacturer_id') }}</div>
                                        </div>
                                    </div></td>
                                <td class="hidden py-6 pr-8 sm:table-cell">
                                    € {{ carmarket_price_display_format($vehicle->getPropertyForDisplaying('price_in_euro')) }}
                                </td>
                                <td class="py-6 font-medium text-left whitespace-nowrap">
                                    {{ $vehicle->getPropertyForDisplaying('company') }}
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($vehicle->contacts as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                    <br>
                                                    <dt class="mt-1">
                                                        <div class="absolute flex items-center mt-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <p class="ml-5 text-sm leading-6 text-gray-500">{{ $user->email }}</p>
                                                    </dt>
                                                    <dt class="mt-1">
                                                        <div class="absolute flex items-center mt-0.5">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                                            </svg>
                                                        </div>
                                                        <p class="ml-5 mb-2 text-sm leading-6 text-gray-500">{{ $user->telephone }}</p>
                                                    </dt>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Billing -->
            <div class="mt-16">
                <h2 class="sr-only">Inquriy Summary</h2>
                <div class="bg-gray-100 py-6 px-4 sm:px-6 sm:rounded-lg lg:px-8 lg:py-8 lg:grid lg:grid-cols-12 lg:gap-x-8">
                    <dl class="grid grid-cols-2 gap-6 text-sm sm:grid-cols-2 md:gap-x-8 lg:col-span-7">
                        <div>
                            <dt class="font-medium text-gray-900">Billing Address</dt>
                            <dd class="mt-3 text-gray-500">
                                <span class="block">{{ $company->name }}</span>
                                <span class="block">{{ $company->address }}</span>
                            </dd>
                        </div>
                    </dl>
                    <dl class="mt-8 divide-y divide-gray-200 text-sm lg:mt-0 lg:col-span-5">
                        <div class="pb-4 flex items-center justify-between">
                            <dt class="text-gray-600">Total vehicles</dt>
                            <dd class="font-medium text-gray-900">{{ $totalVehicles }}</dd>
                        </div>
                        <div class="py-4 flex items-center justify-between">
                            <dt class="text-gray-600">Sellers</dt>
                            <dd class="font-medium text-gray-900">{{ count($enquiryItems) }}</dd>
                        </div>
                        <div class="pt-4 flex items-center justify-between">
                            <dt class="text-gray-600">Inquriy total</dt>
                            <dd class="font-medium text-indigo-600">€ {{ carmarket_price_display_format($totalPrice) }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
