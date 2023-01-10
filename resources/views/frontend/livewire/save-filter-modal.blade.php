<div class="h-auto">
    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left pb-4">
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Save Filter
        </h3>

        <div class="mt-2">
            <p class="text-sm leading-5 text-gray-500">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Filter name</label>
                <div class="mt-1">
                    <input type="text" wire:model="name" name="name" size="40" id="name" class="bg-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 block sm:text-sm border-gray-300 rounded-md">
                </div>
            </div>
            </p>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-2">
        <div>
            <button @click="$wire.closeModal()" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Close
            </button>
            <button wire:click="saveFilters" @click="open = false" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Save
            </button>
        </div>
        <div>

        </div>
    </div>
</div>
