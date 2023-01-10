<div>
    <livewire:approval-notification type="seller"/>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="px-4 py-8 sm:px-0">
            @include('frontend.partials.bulk-actions-transaction')
            <div class="bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:pb-24 lg:px-8">
                    <div class="mt-10">
                        <div class="space-y-20">
                            <div>
                                <table class="mt-4 w-full text-gray-500 sm:mt-6">
                                    <caption class="sr-only">
                                        Vehicles
                                    </caption>
                                    <thead class="sr-only text-sm text-gray-500 text-left sm:not-sr-only">
                                    <tr>
                                        @if($listType === 'enquiry')
                                            <th scope="col" class="sm:w-2/5 lg:w-1/6 w-0 py-3 font-normal"></th>
                                        @endif
                                        <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">Vehicle</th>
                                        <th scope="col" class="hidden w-1/5 pr-8 py-3 font-normal sm:table-cell">Price</th>
                                        <th scope="col" class="hidden pr-8 py-3 font-normal sm:table-cell">Buyer</th>
                                        <th scope="col" class="sm:w-2/5 lg:w-1/4 w-0 py-3 font-normal"><div class="ml-10">Status</div></th>
                                        <th scope="col" class="sm:w-2/5 lg:w-1/4 w-0 py-3 font-normal">Updated At</th>
                                    </tr>
                                    </thead>
                                    <tbody class="border-b border-gray-200 divide-y divide-gray-200 text-sm sm:border-t">
                                    @foreach($vehicles as $vehicle)
                                        @if($vehicle->transaction_status === \App\Transaction::TRANSACTION_STATUS_VEHICLE_REMOVED_DURING_TRANSACTION)
                                            @include('frontend.livewire.transaction-list.partials.list.vehicle-removed-during-transaction', ['vehicle' => $vehicle])
                                        @else
                                            <tr>
                                                @if($listType === 'enquiry')
                                                    <td class="py-6 pr-8">
                                                        <input type="checkbox" wire:model="selectedRows" value="{{ $vehicle->transaction_id }}" class="form-checkbox border-cool-gray-300 block transition duration-150 ease-in-out sm:text-sm sm:leading-5 clickable"/>
                                                    </td>
                                                @endif
                                                <td class="py-6 pr-8">
                                                    <div class="flex items-center">
                                                        <img src="{{url('/images/logos/' . Illuminate\Support\Str::snake(strtolower($vehicle->brand)) . '.svg')}}" class="w-16 h-16 object-center object-cover rounded mr-6">
                                                        <div>
                                                            <div class="font-medium text-gray-900">
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800"> {{ $vehicle->getPropertyForDisplaying('condition_type') }} </span>
                                                                <a href="#">{{ $vehicle->getPropertyForDisplaying('brand') }} {{ $vehicle->getPropertyForDisplaying('model') }} {{ $vehicle->getPropertyForDisplaying('version_description') }}</a>
                                                            </div>
                                                            <div class="font-medium text-gray-900">{{ $vehicle->getPropertyForDisplaying('manufacturer_id') }}</div>
                                                        </div>
                                                    </div></td>
                                                <td class="hidden py-6 pr-8 sm:table-cell">
                                                    € {{ carmarket_price_display_format($vehicle->getPropertyForDisplaying('price_in_euro')) }}
                                                </td>
                                                <td class="py-6 font-medium text-left whitespace-nowrap">
                                                    <a href="#" class="text-custom-indigo">
                                                        {{ $vehicle->buyer }}
                                                    </a> <br>
                                                    #{{ $vehicle->enquiry_id }} - {{ $vehicle->enquiry_count }} vehicles total
                                                </td>
                                                <td class="py-4 whitespace-nowrap text-sm text-gray-500 relative">
                                                    <div class="ml-10">
                                                        @if ($listType === 'enquiry' && $vehicle->transaction_status === \App\Transaction::TRANSACTION_STATUS_IN_PROGRESS)
                                                            <button wire:click="$emit('openTransactionModal', '{{ $vehicle->transaction_id }}')" type="button" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white cart-button-bg hover:cart-button-bg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:cart-button-bg">
                                                                Set status
                                                            </button>
                                                        @else
                                                            @switch($vehicle->transaction_status)
                                                                @case(\App\Transaction::TRANSACTION_STATUS_IN_PROGRESS)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                In progress
                                                            </span>
                                                                @break
                                                                @case(\App\Transaction::TRANSACTION_STATUS_APPROVED)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                Approved
                                                            </span>
                                                                @break
                                                                @case(\App\Transaction::TRANSACTION_STATUS_DENIED)
                                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                Denied
                                                            </span>
                                                                @break
                                                            @endswitch
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="py-6 font-medium text-left whitespace-nowrap">
                                                    {{ $vehicle->transaction_updated_at }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    {{ $vehicles->links('frontend.pagination.tailwind') }}
                </div>
            </div>
            <livewire:transaction-management/>
        </div>
    </div>
</div>
