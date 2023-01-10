<x-frontend.layouts.app>
    <x-card class="mb-12" title="Documents">
        <x-icon-link text="Back" icon="arrow-left" link="{{ url()->previous() }}"/>
        <ul class="px-0">
            @foreach($vinDocument as $documentDescription => $documentName)
                <a href="{{ route('used_cars.detail.documents.get', ['vehicle' => $vehicle->id, 'document' => $documentName]) }}"><li class="border list-none  rounded-sm px-3 py-3">{{ $documentDescription }}</li></a>
            @endforeach
        </ul>
    </x-card>
</x-frontend.layouts.app>
