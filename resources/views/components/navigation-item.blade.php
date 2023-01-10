@if(request()->fullUrl() === $link)
    <a href="{{ $link }}" class="text-gray-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md bg-gray-200" target="{{ $target }}">
        @svg($icon, ['class' => 'text-gray-600 mr-3 h-6 w-6'])
        {{ $label }}
    </a>
@else
    <a href="{{ $link }}" class="text-gray-900 group w-full flex items-center pl-2 py-2 text-sm font-medium rounded-md" target="{{ $target }}">
        @svg($icon, ['class' => 'text-gray-600 mr-3 h-6 w-6'])
        {{ $label }}
    </a>
@endif
