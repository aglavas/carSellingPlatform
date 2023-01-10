<div class="pt-2">
@if($selected != '')
    <button wire:click="$emit('deleteFilter')" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
        Delete
    </button>
@endif
</div>
