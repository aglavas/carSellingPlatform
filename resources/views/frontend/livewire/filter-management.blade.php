<div>
    @if($show)
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700">Saved filters</label>
            <select id="filters" wire:model="selected" wire:change="$emit('filterSelected', $event.target.value)" name="filters" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                <option value=''>Choose a filter</option>
                @foreach($filters as $filter)
                    <option value={{ $filter->id }}>{{ $filter->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
<livewire:filter-actions :selected="$selected"/>
<livewire:flash-message/>
