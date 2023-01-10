<div wire:init="initializeFilters">
    <livewire:transactions-list :transactions="$transactions" :type="$type" :listType="$listType" />
</div>
<livewire:transaction-search-filter :resource="$resource" :filters="$filters" :selectedFilter="$selectedFilter" :transactionType="$type" :listType="$listType" />
