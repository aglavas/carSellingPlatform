<div>
    <div class="sm:col-span-2">
        <legend class="block text-sm font-medium text-gray-700 font-bold">Choose your stock type (What segment are you responsible for?)</legend>
        <legend class="block text-sm font-small text-gray-700">You can pick on of the list mentioned below.</legend>
        <div class="mt-4 grid grid-cols-1 gap-y-4">
            <div class="flex items-center">
                @if (old('stock_type') === 'UC')
                    <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="stock_type" value="UC" type="radio" checked>
                @else
                    <input wire:click="$emit('stock-type-selected', 'UC')" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="stock_type" value="UC" type="radio">
                @endif
                <label class="ml-3" for="budget_under_25k"> <span class="block text-sm text-gray-700">Used Cars</span> </label>
            </div>
            <div class="flex items-center">
                @if (old('stock_type') === 'NC')
                    <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="stock_type" value="NC" type="radio" checked>
                @else
                    <input wire:click="$emit('stock-type-selected', 'NC')" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="stock_type" value="NC" type="radio">
                @endif
                <label class="ml-3" for="budget_25k-50k"> <span class="block text-sm text-gray-700">New Cars</span> </label>
            </div>
            <div class="flex items-center">
                @if (old('stock_type') === 'both')
                    <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="stock_type" value="both" type="radio" checked>
                @else
                    <input wire:click="$emit('stock-type-selected', 'both')" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="stock_type" value="both" type="radio">
                @endif
                <label class="ml-3" for="budget_25k-50k"> <span class="block text-sm text-gray-700">Both (used and new cars)</span> </label>
            </div>
        </div>
        @error('stock_type')
        <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
            <p><strong>{{ $message }}</strong></p>
        </div>
        @enderror
    </div>
</div>
