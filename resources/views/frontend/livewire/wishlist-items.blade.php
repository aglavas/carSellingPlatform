<div>
    <x-table>
        <x-slot name="head">
            <x-table.heading>Id</x-table.heading>
            <x-table.heading>Vehicle Type</x-table.heading>
            <x-table.heading>Status</x-table.heading>
            <x-table.heading>Created at</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @foreach($wishlistItems as $wishlistItem)
                <x-table.row class="{{ ($wishlistItem->id == $previewId)? 'bg-blue-50' : (($loop->even) ? 'bg-gray-50' : 'bg-white') }} cursor-pointer" wire:loading.class.delay="opacity-50" wire:key="row-{{ $wishlistItem->id }}">
                    <x-table.cell wire:click="previewVehicle({{ $wishlistItem->id }})">
                        {{ $wishlistItem->id }}
                    </x-table.cell>
                    <x-table.cell wire:click="previewVehicle({{ $wishlistItem->id }})">
                        {{ $wishlistItem->vehicle_type }}
                    </x-table.cell>
                    <x-table.cell wire:click="previewVehicle({{ $wishlistItem->id }})">
                        {{ $wishlistItem->status }}
                    </x-table.cell>
                    <x-table.cell wire:click="previewVehicle({{ $wishlistItem->id }})">
                        {{ $wishlistItem->created_at }}
                    </x-table.cell>
                </x-table.row>
            @endforeach
        </x-slot>
    </x-table>
</div>
