<div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
    <div class="min-h-0 flex-1 flex flex-col py-6 overflow-y-scroll bg-gray-50">
        <div class="px-4 sm:px-6">
            <div class="flex items-start justify-between">
                <h2 id="slide-over-heading" class="text-lg font-medium text-gray-900">
                    {{ $vehicle->brand }} {{ $vehicle->model }} {{ $vehicle->version_description }} {{ $vehicle->engine }}
                </h2>
                <div class="ml-3 h-7 flex items-center">
                    <button @click="$wire.closeSlideOver()"
                            class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="sr-only">Close panel</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="mt-6 relative flex-1 px-4 sm:px-6">
            <x-data-list>
                <x-data-list-item label="VIN" value="{{ $vehicle->vin }}"/>
                <x-data-list-item label="KM" value="{{ $vehicle->km }}"/>
                <x-data-list-item label="Price in Euro" value="€{{ $vehicle->price_in_euro }}"/>
            </x-data-list>

            <h2 class="pt-4">Prospects</h2>
            <x-prospect-list-compact :prospects="$openTransactionsPerUser" :closedProspects="$closedTransactions"/>

            {{--
            <x-data-list>
                <x-data-list-item label="Engine" value="{{ $vehicle->engine }}"/>
                <x-data-list-item label="Fuel Type" value="{{ $vehicle->fuel_type }}"/>
                <x-data-list-item label="Gearbox" value="{{ $vehicle->gearbox }}"/>
                <x-data-list-item label="Km" value="{{ $vehicle->km }}"/>
                <x-data-list-item label="First Registration" value="{{ $vehicle->firstregistration }}"/>
                <x-data-list-item label="First Registration Year"
                                  value="{{ (is_null($vehicle->firstregistration) ? '' : $vehicle->firstregistration->format('Y')) }}"/>
                <x-data-list-item label="Color Code" value="{{ $vehicle->color_code }}"/>
                <x-data-list-item label="Color Description" value="{{ $vehicle->color_description }}"/>
                <x-data-list-item label="Option Code Description" value="{{ $vehicle->option_code_description }}"/>
                <x-data-list-item label="Option Code Description English"
                                  value="{{ $vehicle->option_code_description_english }}"/>
                <x-data-list-item label="Currency" value="{{ $vehicle->currency_iso_codification }}"/>
                <x-data-list-item label="B2B Price Excl. Vat" value="{{ $vehicle->b2b_price_ex_vat }}"/>
                <x-data-list-item label="Price in Euro (Approx.)" value="{{ $vehicle->price_in_euro }}"/>
                <x-data-list-item label="VAT Deductible?" value="{{ $vehicle->vat_deductible }}"/>
                <x-data-list-item label="Damages Excl. Vat" value="{{ $vehicle->damages_excl_vat }}"/>
                <x-data-list-item label="VpVu" value="{{ $vehicle->vpvu }}"/>
                <x-data-list-item label="Origin" value="{{ $vehicle->origin }}"/>
                <x-data-list-item label="Disponibility" value="{{ $vehicle->disponibility }}"/>
                <x-data-list-item label="Loading Place"
                                  value="{{ (is_null($vehicle->disponibility) ? '️✔️' : $vehicle->disponibility->format('Y-m-d')) }}"/>
                <x-data-list-item label="Co2" value="{{ $vehicle->co2 }}"/>
                <x-data-list-item label="Language" value="{{ $vehicle->language_option_code_description }}"/>
                <x-data-list-item label="Url Address" value="Extract to property"/>
                <x-data-list-item label="Country" value="{{ $vehicle->country->name ?? '' }}"/>
                <x-data-list-item label="Company" value="{{ $vehicle->company->name ?? '' }}"/>
                <x-data-list-item label="Created At" value="{{ $vehicle->created_at }}"/>
                <x-data-list-item label="Exchange Rate" value="Extract to property"/>
            </x-data-list>
            --}}
        </div>
    </div>
    <div class="flex-shrink-0 px-4 py-4 flex justify-end">
        <button wire:click="$emit('closeSlideOver')" type="button"
                class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Cancel
        </button>
    </div>
</div>
