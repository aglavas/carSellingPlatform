<a href="{{ route('wishlist.list') }}" class="w-full flex items-center pl-2 py-2 text-xs font-medium rounded-md" x-data="{showAnimation: false}">
    @svg('heroicon-o-heart', ['class' => 'text-gray-400 hover:text-gray-500 mr-1 h-6 w-6'])
    <button type="button" class="w-5 h-5 items-center border border-transparent rounded-full shadow-sm text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            @cart-count-changed.window="
                showAnimation = true;
                setTimeout(() => showAnimation = false, 1000);
             "
            :class="{ 'animate-ping-once': showAnimation === true }">
        {{ $itemCount }}
    </button>
</a>
