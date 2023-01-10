<div class="z-20 relative"
     x-data="{ open: false }"
     x-show="open"
     @open-dropdown.window="if ($event.detail.id == 3) open = true"
     @click.away="open = false"
>
    <div x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-1"
         class="absolute z-10 inset-x-0 transform shadow-lg"
    >
        <div class="bg-white">
            <div class="max-w-7xl mx-auto grid gap-y-6 px-4 py-6 sm:grid-cols-2 sm:gap-8 sm:px-6 sm:py-8 lg:grid-cols-3 lg:px-8 lg:py-12 xl:py-16">

                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                    <a href="{{ route('order.list', ['userType' => 'admin', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/chart-bar -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        All Orders
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Show all orders <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/sparkles -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        Approved for me
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Vehicles approved for me <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/sparkles -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        Approved outgoing
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Vehicles I approved <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>
                @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyerAndSeller())
                    <a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/sparkles -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        Approved for me
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Vehicles approved for me <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/sparkles -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        Approved outgoing
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Vehicles I approved <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>
                @elseif(\Illuminate\Support\Facades\Auth::user()->isSeller())
                    <a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/sparkles -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        Approved outgoing
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Vehicles I approved <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>
                @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyer())
                    <a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}" class="-m-3 p-3 flex flex-col justify-between rounded-lg hover:bg-gray-50 transition ease-in-out duration-150">
                        <div class="flex md:h-full lg:flex-col">
                            <div class="flex-shrink-0">
                                <div class="inline-flex items-center justify-center h-10 w-10 rounded-md cart-button-bg text-white sm:h-12 sm:w-12">
                                    <!-- Heroicon name: outline/sparkles -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 md:flex-1 md:flex md:flex-col md:justify-between lg:ml-0 lg:mt-4">
                                <div>
                                    <p class="text-base font-medium text-gray-900">
                                        Approved for me
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">

                                    </p>
                                </div>
                                <p class="mt-2 text-sm font-medium text-indigo-600 lg:mt-4">Vehicles approved for me <span aria-hidden="true">→</span></p>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
