<div>
    <div class="flow-root mt-6">
        <ul class="-my-5 divide-y divide-gray-200">
        @foreach($prospects as $prospect)
            <li class="py-4">
                    <div class="flex items-center space-x-4">
                        {{--
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        --}}
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $prospect['user']->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900">
                                <a href="tel:{{ $prospect['user']->telephone ?? $prospect['user']->mobile }}">{{ $prospect['user']->telephone ?? $prospect['user']->mobile }}</a>
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $prospect['user']->company->name }}
                            </p>

                            <p class="text-sm text-gray-500">
                                Total vehicles requested: {{ $prospect['count'] }}
                            </p>
                            <div>
                                @if($prospect['transaction'])
                                    <livewire:order-management-buttons :transaction="$prospect['transaction']" key="{{ rand() }}"/>
                                @endif
                            </div>
                        </div>

                    </div>
                </li>
            @endforeach

            @foreach($closedProspects as $closedProspect)
                <li class="py-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">
                                {{ $closedProspect['user']->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900">
                                <a href="tel:{{ $closedProspect['user']->telephone ?? $closedProspect['user']->mobile }}">{{ $closedProspect['user']->telephone ?? $closedProspect['user']->mobile }}</a>
                            </p>
                            <p class="text-sm text-gray-500">
                                {{ $closedProspect['user']->company->name }}
                            </p>

                            @if ($closedProspect['status'] === 'approved')
                                <p class="text-sm text-gray-500 pt-2">
                                    <div class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-green-300 text-sm leading-5 font-medium rounded-full text-green-700 bg-white hover:bg-green-50">
                                        {{ $closedProspect['status']}}
                                    </div>
                                </p>
                            @else
                                <p class="text-sm text-gray-500 pt-2">
                                    <div class="mr-4 inline-flex items-center shadow-sm px-2.5 py-0.5 border border-red-300 text-sm leading-5 font-medium rounded-full text-red-700 bg-white hover:bg-red-50">
                                        {{ $closedProspect['status']}}
                                    </div>
                                </p>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

</div>
