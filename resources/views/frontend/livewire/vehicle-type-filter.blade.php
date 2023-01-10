<div>
    <label for="vehicle_type" class="block text-sm font-medium text-gray-700">Vehicle Type</label>
    <select id="vehicle_type" name="vehicle_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
        @foreach($options as $key => $item)
            @if ($key === $status)
                <option wire:click="apply('{{ $key }}')" value="{{ $key }}" selected>{{ $item }}</option>
            @else
                <option wire:click="apply('{{ $key }}')" value="{{ $key }}">{{ $item }}</option>
            @endif
        @endforeach
    </select>
</div>
