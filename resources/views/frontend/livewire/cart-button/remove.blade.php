<button wire:click="remove" wire:loading.attr="disabled" type="button" class="flex @if($fullWidth) w-full @else w-48 @endif mr-3 bg-red-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-red-500">
    @svg('heroicon-o-shopping-cart', ['class' => '-ml-1 mr-3 h-5 w-5'])
    Remove
</button>
