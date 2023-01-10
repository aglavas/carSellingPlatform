<div {{ $attributes->merge(['class' => 'bg-white overflow-hidden shadow rounded-lg divide-y divide-gray-200']) }}>
    @if($title)
    <div class="px-4 py-5 sm:px-6">
        <h3 class="text-lg leading-6 font-medium text-gray-500">
            {{ $title }}
        </h3>
    </div>
    @endif
    <div class="{{ $contentPadding ? 'px-4 py-5 sm:p-6' : '' }}">
        {{ $slot }}
    </div>
</div>
