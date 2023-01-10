<div wire:init="initializeFilters">
    <livewire:vehicle-list-table :resource="$resource" :resourceClass="$resourceClass"/>
</div>
<x-slot name="pageTitle">
    {{ $resource->pageTitle ?? 'Vehicle search' }}
</x-slot>
<livewire:vehicle-search-filter-table :resource="$resource" :resourceClass="$resourceClass" :filters="$filters" :selectedFilter="$selectedFilter" />

