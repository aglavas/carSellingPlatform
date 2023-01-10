<div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 hover:bg-gray-100">
    <dt class="text-sm font-medium text-gray-500">
        {{ $label }}
    </dt>
    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
        @if ($link)
            @if (preg_match('^(http|https)://^', $value))
                <a class="underline" target="_blank" href="{{$value}}"> Link </a>
            @else
                <a class="underline" target="_blank" href="//{{$value}}"> Link </a>
            @endif
        @else
            {{ $value }}
        @endif
    </dd>
</div>
