<a href="{{$link}}">
    @if($disabled)
        <button disabled {{ $attributes->merge(['class' => 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md']) }}
                aria-current="page">
            @svg('heroicon-s-'.$icon, ['class' => 'text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 mt-4 h-6 w-6'])
            <span class="truncate">
                  {{ $text }}
                </span>
        </button>
    @else
        <button {{ $attributes->merge(['class' => 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-3 py-2 text-sm font-medium rounded-md']) }}
                aria-current="page">
            @svg('heroicon-s-'.$icon, ['class' => 'text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 mt-4 h-6 w-6'])

            <span class="truncate">
                  {{ $text }}
                </span>
        </button>
    @endif
</a>
