<div wire:init="initializeFilters">
    <livewire:vehicle-list :resource="$resource" :resourceClass="$resourceClass"/>
</div>
<x-slot name="pageTitle">
    {{ $resource->pageTitle ?? 'Vehicle search' }}
</x-slot>
<livewire:vehicle-search-filter :resource="$resource" :resourceClass="$resourceClass" :filters="$filters" :selectedFilter="$selectedFilter" />

