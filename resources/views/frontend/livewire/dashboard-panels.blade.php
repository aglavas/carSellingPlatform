
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="pb-5">
        <div class="my-12"></div><div class="pb-5 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">My Transctions</h3>
        </div>
    </div>
    <div class="pb-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
           Requests sent out (last 2 weeks)
        </h3>
        <div class="grid grid-cols-3 gap-4">
            <div class="mt-5">
                <div class="flex flex-col bg-white overflow-hidden shadow rounded-lg">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <!-- Heroicon name: outline/users -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Open
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $openRequests }}
                                    </div>

                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('enquiry.list', ['userType' => 'buyer', 'status' => ['in_progress']]) }}" class="font-medium text-yellow-600 hover:text-yellow-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex flex-col bg-white overflow-hidden shadow rounded-lg">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <!-- Heroicon name: outline/mail-open -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Approved
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $acceptedRequests }}
                                    </div>

                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}" class="font-medium text-green-600 hover:text-green-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex flex-col bg-white overflow-hidden shadow rounded-lg">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <!-- Heroicon name: outline/cursor-click -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Declined
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $declinedRequests }}
                                    </div>

                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('enquiry.list', ['userType' => 'buyer', 'status' => ['denied']]) }}" class="font-medium text-red-600 hover:text-red-500"> View all<span class="sr-only"> Avg. Click Rate stats</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @if(auth()->user()->isSeller())
        <div class="pb-5">
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            Requests received (last 2 weeks)
        </h3>
        <div class="grid grid-cols-3 gap-4">
            <div class="mt-5">
                <div class="flex flex-col bg-white overflow-hidden shadow rounded-lg">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <!-- Heroicon name: outline/users -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Open
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $openSellerRequests }}
                                    </div>

                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('enquiry.list', ['userType' => 'seller', 'status' => ['in_progress']]) }}" class="font-medium text-yellow-600 hover:text-yellow-500"> View all<span class="sr-only"> Total Subscribers stats</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex flex-col bg-white overflow-hidden shadow rounded-lg">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <!-- Heroicon name: outline/mail-open -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 15.536c-1.171 1.952-3.07 1.952-4.242 0-1.172-1.953-1.172-5.119 0-7.072 1.171-1.952 3.07-1.952 4.242 0M8 10.5h4m-4 3h4m9-1.5a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Approved
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $acceptedSellerRequests }}
                                    </div>

                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}" class="font-medium text-green-600 hover:text-green-500"> View all<span class="sr-only"> Avg. Open Rate stats</span></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <div class="flex flex-col bg-white overflow-hidden shadow rounded-lg">
                    <div class="flex-grow px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <!-- Heroicon name: outline/cursor-click -->
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Declined
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900">
                                        {{ $declinedSellerRequests }}
                                    </div>

                                </dd>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="{{ route('enquiry.list', ['userType' => 'seller', 'status' => ['denied']]) }}" class="font-medium text-red-600 hover:text-red-500"> View all<span class="sr-only"> Avg. Click Rate stats</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endif
</div>
