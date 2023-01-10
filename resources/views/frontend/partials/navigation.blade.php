<div class="space-y-1">
    @if(request()->url() === route('start'))
        <a href="{{ route('start') }}" class="bg-gray-200 text-gray-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md">
            @svg('heroicon-o-home', ['class' => 'text-blue-600 mr-3 h-6 w-6'])
            Start
        </a>
    @else
        <a href="{{ route('start') }}" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md">
            @svg('heroicon-o-home', ['class' => 'text-blue-600 mr-3 h-6 w-6'])
            Start
        </a>
    @endif
    {{--<x-frontend.sidebar.collapsible-item title="New Cars" icon="sparkles" iconColor="yellow" :items="[--}}
                                    {{--[--}}
                                        {{--'link' => route('vehicle-search', ['type' => 'fca']),--}}
                                        {{--'label' => 'FCA'--}}
                                    {{--],--}}
                                    {{--[--}}
                                        {{--'link' => route('vehicle-search', ['type' => 'opel']),--}}
                                        {{--'label' => 'Opel'--}}
                                    {{--],--}}
                                    {{--[--}}
                                        {{--'link' => route('vehicle-search', ['type' => 'mercedes']),--}}
                                        {{--'label' => 'Mercedes-Benz'--}}
                                    {{--],--}}
                                    {{--[--}}
                                        {{--'link' => route('vehicle-search', ['type' => 'pcds']),--}}
                                        {{--'label' => 'PCD'--}}
                                    {{--],--}}
                                    {{--[--}}
                                        {{--'link' => route('vehicle-search', ['type' => 'unified_view']),--}}
                                        {{--'label' => 'Unified view'--}}
                                    {{--]--}}
                                {{--]--}}
                            {{--"--}}

    {{--/>--}}
    @if(request()->url() === route('vehicle-search', ['type' => 'all']))
        <a href="{{ route('vehicle-search', ['type' => 'all']) }}" dusk="used-cars" class="text-green-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md bg-green-100">
            @svg('heroicon-o-badge-check', ['class' => 'text-green-600 mr-3 h-6 w-6'])
            All cars
        </a>
    @else
        <a href="{{ route('vehicle-search', ['type' => 'all']) }}" dusk="used-cars" class="text-gray-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md">
            @svg('heroicon-o-badge-check', ['class' => 'text-green-600 mr-3 h-6 w-6'])
            All cars
        </a>
    @endif
    {{--@if(request()->url() === route('vehicle-search', ['type' => 'used']))--}}
        {{--<a href="{{ route('vehicle-search', ['type' => 'used']) }}" dusk="used-cars" class="text-green-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md bg-green-100">--}}
            {{--@svg('heroicon-o-badge-check', ['class' => 'text-green-600 mr-3 h-6 w-6'])--}}
            {{--Used Cars--}}
        {{--</a>--}}
    {{--@else--}}
        {{--<a href="{{ route('vehicle-search', ['type' => 'used']) }}" dusk="used-cars" class="text-gray-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md">--}}
            {{--@svg('heroicon-o-badge-check', ['class' => 'text-green-600 mr-3 h-6 w-6'])--}}
            {{--Used Cars--}}
        {{--</a>--}}
    {{--@endif--}}
    @if(\Illuminate\Support\Facades\Auth::user()->isBuyerAndSeller())
        <x-frontend.sidebar.collapsible-item title="Enquiries" icon="clipboard-list" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'buyer', 'listType' => 'enquiries']),
                                        'label' => 'My requests'
                                    ],
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries', 'status' => ['in_progress']]),
                                        'label' => 'Buying requests'
                                    ]
                                ]
                            "/>
        @elseif(\Illuminate\Support\Facades\Auth::user()->isSeller())
            <x-frontend.sidebar.collapsible-item title="Enquiries" icon="clipboard-list" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries', 'status' => ['in_progress']]),
                                        'label' => 'Buying requests'
                                    ]
                                ]
                            "/>
        @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyer())
            <x-frontend.sidebar.collapsible-item title="Enquiries" icon="clipboard-list" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'buyer', 'listType' => 'enquiries', 'status' => ['in_progress']]),
                                        'label' => 'My requests'
                                    ]
                                ]
                            "/>
        @elseif(\Illuminate\Support\Facades\Auth::user()->isAdmin())
            <x-frontend.sidebar.collapsible-item title="Enquiries" icon="clipboard-list" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'buyer', 'listType' => 'enquiries', 'status' => ['in_progress']]),
                                        'label' => 'My requests'
                                    ],
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'seller', 'listType' => 'enquiries', 'status' => ['in_progress']]),
                                        'label' => 'Buying requests'
                                    ]
                                ]
                            "/>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
            <x-frontend.sidebar.collapsible-item title="Orders" icon="currency-euro" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'admin', 'listType' => 'admin', 'status' => ['approved']]),
                                        'label' => 'All orders'
                                    ],
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders', 'status' => ['approved']]),
                                        'label' => 'My requests'
                                    ],
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders', 'status' => ['approved']]),
                                        'label' => 'Buying requests'
                                    ]
                                ]
                            "/>
    @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyerAndSeller())
        <x-frontend.sidebar.collapsible-item title="Orders" icon="currency-euro" icon-color="indigo" :items="[
                                [
                                    'link' => route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders', 'status' => ['approved']]),
                                    'label' => 'My requests'
                                ],
                                [
                                    'link' => route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders', 'status' => ['approved']]),
                                    'label' => 'Buying requests'
                                ]
                            ]
                        "/>
    @elseif(\Illuminate\Support\Facades\Auth::user()->isSeller())
        <x-frontend.sidebar.collapsible-item title="Orders" icon="currency-euro" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'seller', 'listType' => 'orders', 'status' => ['approved']]),
                                        'label' => 'Buying requests'
                                    ]
                                ]
                            "/>
        @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyer())
            <x-frontend.sidebar.collapsible-item title="Orders" icon="currency-euro" icon-color="indigo" :items="[
                                    [
                                        'link' => route('enquiry.list', ['userType' => 'buyer', 'listType' => 'orders', 'status' => ['approved']]),
                                        'label' => 'My requests'
                                    ]
                                ]
                            "/>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user()->isSeller())
        <x-navigation-item :link="route('car.upload')" icon="heroicon-o-upload" label="Upload List"/>
    @endif
    <x-navigation-item :link="route('faq')" icon="heroicon-o-question-mark-circle" label="FAQ" />
    <x-navigation-item :link="route('contact.show')" icon="heroicon-o-support" label="Contact Form" />
    <x-frontend.sidebar.collapsible-item title="Analytics" icon="chart-pie" icon-color="indigo" :items="[
                            [
                                'link' => route('analytics', ['type' => 'dashboard']),
                                'label' => 'Dashboard'
                            ]
                        ]
                    "/>
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <x-navigation-item :link="route('nova.login')" icon="heroicon-o-key" label="Admin Panel" />
    @endif
    <x-navigation-item :link="route('announcements')" icon="heroicon-o-speakerphone" label="What's new" />
</div>
