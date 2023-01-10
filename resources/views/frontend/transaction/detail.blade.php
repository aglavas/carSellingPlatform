<x-frontend.layouts.app>
    <x-card>
        <x-icon-link text="Back" icon="arrow-left" link="{{ url()->previous() }}"/>
        <x-slot name="title">
            <h2 id="column-1" class="text-lg leading-6 font-medium text-gray-900 relative">
                {{ $vehicle['brand'] }} {{ $vehicle['model'] }} {{ $vehicle['version_description'] }}
                <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-green-800">
                    Status: TODO: Add field to vehicle: status, see <a class="ml-1 underline" href="https://emilfreygroup.atlassian.net/jira/software/c/projects/BCP/boards/340/roadmap?selectedIssue=BCP-48" target="_blank">Jira issue</a>

                </p>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    {{ $vehicle['vin'] }}
                </p>
                <img src="{{ asset('images/logos/'.Str::snake(strtolower($vehicle['brand'])).'.svg') }}" class="w-16 absolute right-0 top-0" />
            </h2>
        </x-slot>
        <img src="{{ asset('images/car-placeholder.jpg') }}" />
        <x-data-list>
            @foreach($carData as $key => $value)
                <x-data-list-item label="{{ $key }}" value="{{ $value }}" />
            @endforeach
        </x-data-list>
    </x-card>
</x-frontend.layouts.app>
a
