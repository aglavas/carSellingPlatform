<div>
    <form class="space-y-4">
        <div class="flex items-center">
            @if ($perPage == 40)
                <input wire:click="perPage('40')" id="filter-category-0" name="perPage" value="40" type="radio" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" checked>
            @else
                <input wire:click="perPage('40')" id="filter-category-0" name="perPage" value="40" type="radio" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
            @endif
            <label for="filter-category-0" class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                40
            </label>
        </div>

        <div class="flex items-center">
            @if ($perPage == 80)
                <input wire:click="perPage('80')" id="filter-category-1" name="perPage" value="80" type="radio" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" checked>
            @else
                <input wire:click="perPage('80')" id="filter-category-1" name="perPage" value="80" type="radio" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
            @endif
            <label for="filter-category-1" class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                80
            </label>
        </div>

        <div class="flex items-center">
            @if ($perPage == 120)
                <input wire:click="perPage('120')" id="filter-category-2" name="perPage" value="120" type="radio" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500" checked>
            @else
                <input wire:click="perPage('120')" id="filter-category-2" name="perPage" value="120" type="radio" class="h-4 w-4 border-gray-300 rounded text-indigo-600 focus:ring-indigo-500">
            @endif
            <label for="filter-category-2" class="ml-3 pr-6 text-sm font-medium text-gray-900 whitespace-nowrap">
                120
            </label>
        </div>
    </form>
</div>
