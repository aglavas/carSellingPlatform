<div class="mt-3">
    <div class="sm:col-span-2">
        <div class="flex justify-between">
            <label class="block text-sm font-medium text-gray-700" for="country">Country</label>
            <span class="text-sm font-strong text-yellow-500">Required</span>
        </div>
        <select class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" name="country">
            @foreach($countries as $code => $country)
                @if ($code == old('country') || $code == $selected)
                    <option value="{{ $code }}" selected>{{ $country }}</option>
                @else
                    <option value="{{ $code }}">{{ $country }}</option>
                @endif
            @endforeach
        </select>
        @error('country')
        <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
            <p><strong>{{ $message }}</strong></p>
        </div>
        @enderror
    </div>
</div>
