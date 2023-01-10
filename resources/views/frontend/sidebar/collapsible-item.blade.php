@switch($iconColor)
    @case('yellow')
        @php
            $textColor = 'text-yellow-900';
            $hoverTextColor = 'hover:text-yellow-900';
            $bgColor = 'bg-yellow-200';
            $hoverBgColor = 'hover:bg-yellow-50';
            $iconColorText = 'text-yellow-400';
            $groupHoverTextColor = 'group-hover:text-yellow-500';
        @endphp
        @break
    @case('green')
        @php
            $textColor = 'text-green-900';
            $hoverTextColor = 'hover:text-green-900';
            $bgColor = 'bg-green-200';
            $hoverBgColor = 'hover:bg-green-50';
            $iconColorText = 'text-green-400';
            $groupHoverTextColor = 'group-hover:text-green-500';
        @endphp
    @break
    @case('indigo')
        @php
            $textColor = 'text-indigo-900';
            $hoverTextColor = 'hover:text-indigo-900';
            $bgColor = 'bg-indigo-200';
            $hoverBgColor = 'hover:bg-indigo-50';
            $iconColorText = 'text-indigo-400';
            $groupHoverTextColor = 'group-hover:text-indigo-500';
        @endphp
    @break
    @default
        @php
            $textColor = 'text-gray-900';
            $hoverTextColor = 'hover:text-gray-900';
            $bgColor = 'bg-gray-200';
            $hoverBgColor = 'hover:bg-gray-50';
            $iconColorText = 'text-gray-400';
            $groupHoverTextColor = 'group-hover:text-gray-500';
        @endphp
        @break


@endswitch
@php
    $urlToCompare =  '/'.request()->path();
@endphp
<div class="space-y-1" x-data="{collapsed: {{ in_array($urlToCompare, collect(data_get($items, '*.link'))->map(function($item){ return parse_url($item)['path'];})->toArray())? 'false' : 'true' }}}">
    <button @click="collapsed = !collapsed" class="group w-full flex items-center pl-2 pr-1 py-2 text-sm font-medium rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
        @svg('heroicon-s-'.$icon, ['class' => $iconColorText.' '.$groupHoverTextColor.' mr-3 h-6 w-6'])
        {{ $title }}
        <svg
            :class="{'text-gray-400 rotate-90': !collapsed, 'text-gray-300': !collapsed }"
            class="ml-auto h-5 w-5 transform group-hover:text-gray-400 transition-colors ease-in-out duration-150" viewBox="0 0 20 20" aria-hidden="true">
            <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
        </svg>
    </button>
    <div class="space-y-1" x-show="!collapsed">
        @foreach($items as $item)
            @if($urlToCompare === parse_url($item['link'])['path'])
                <a href="{{ $item['link'] }}" class="{{ $textColor }} {{ $bgColor }} {{ $hoverTextColor }} {{ $hoverBgColor }} group w-full flex items-center pl-11 pr-2 py-2 text-sm font-bold rounded-md">
                    {{ $item['label'] }}
                </a>
            @else
                <a href="{{ $item['link'] }}" class="text-gray-700 hover:text-gray-900 hover:bg-gray-50 group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md">
                    {{ $item['label'] }}
                </a>
            @endif
        @endforeach
    </div>
</div>
