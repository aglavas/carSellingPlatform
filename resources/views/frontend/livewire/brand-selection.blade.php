<div>
    @if($showBrands)
        <div class="sm:col-span-2">
            <legend class="block text-sm font-medium text-gray-700 font-bold">Choose your brands</legend>
            <legend class="block text-sm font-small text-gray-700">Please pick your brands.</legend>
            <div class="mt-4 grid grid-cols-2 gap-y-4">
                @foreach($brands as $brandId => $brandName)
                    <div class="flex items-center">
                        @if (in_array($brandId, old('brand',[])))
                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="brand[]" value="{{ $brandId }}" type="checkbox" checked>
                        @else
                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="brand[]" value="{{ $brandId }}" type="checkbox">
                        @endif
                        <label class="ml-3"> <span class="block text-sm text-gray-700">{{ $brandName }}</span> </label>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
