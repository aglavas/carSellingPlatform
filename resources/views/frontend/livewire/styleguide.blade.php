
<div class="mx-auto sm:px-6 lg:px-8">
    <div>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-3xl leading-6 font-medium text-gray-900">
                Grids
            </h1>
        </div>
        <h2 class="text-xl leading-6 font-medium text-gray-900">
            66% / 33%
        </h2>
        <x-columns widths="wide-narrow">
            <x-slot name="wide">
                <x-card>
                    <x-slot name="title">
                        <h2 id="column-1" class="text-lg leading-6 font-medium text-gray-900 relative">
                            Jeep Compass Limited
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-green-800">
                                Status: Reserved
                            </p>
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Status: Available
                            </p>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                ZFA3340000P740559
                            </p>
                            <img src="images/logos/jeep.svg" class="w-16 absolute right-0 top-0" />
                        </h2>
                    </x-slot>
                    <img src="{{ asset('images/car-placeholder.jpg') }}" />
                    <x-data-list>
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                    </x-data-list>
                </x-card>
            </x-slot>
            <x-slot name="narrow">
                <x-card title="Actions">
                    <nav class="space-y-1" aria-label="Sidebar">
                        <x-icon-link text="Add to Cart" icon="shopping-cart" />
                        <x-icon-link text="Add to Wishlist" icon="clipboard-list" />
                        <x-icon-link text="Message seller" icon="mail-open" />
                        <x-icon-link text="Call seller" icon="phone-outgoing" />
                        <x-icon-link text="Documents" icon="document-text" />
                        <x-icon-link text="Reports" icon="document-report" />
                    </nav>
                </x-card>
            </x-slot>
        </x-columns>

        <h2 class="text-xl leading-6 font-medium text-gray-900 pt-12">
            25% / 75%
        </h2>
        <x-columns widths="narrow-wide">
            <x-slot name="narrow">
                <x-card>
                    <x-slot name="title">
                        <h2 id="column-1" class="text-lg leading-6 font-medium text-gray-900">
                            Jeep Compass Limited
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-green-800">
                                Status: Reserved
                            </p>
                            <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Status: Available
                            </p>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                ZFA3340000P740559
                            </p>
                        </h2>
                    </x-slot>
                    <x-data-list>
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                        <x-data-list-item label="Label" value="Value" />
                    </x-data-list>
                </x-card>
            </x-slot>
            <x-slot name="wide">
                <x-card title="Actions">
                    <nav class="space-y-1" aria-label="Sidebar">
                        <x-icon-link text="Add to Cart" icon="shopping-cart" />
                        <x-icon-link text="Add to Wishlist" icon="clipboard-list" />
                        <x-icon-link text="Message seller" icon="mail-open" />
                        <x-icon-link text="Call seller" icon="phone-outgoing" />
                        <x-icon-link text="Documents" icon="document-text" />
                        <x-icon-link text="Reports" icon="document-report" />
                    </nav>
                </x-card>
            </x-slot>
        </x-columns>
    </div>
    <div class="pt-12">
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-3xl leading-6 font-medium text-gray-900">
                Components
            </h1>
        </div>

        <x-card title="Actions">
            <nav class="space-y-1" aria-label="Sidebar">
                <x-icon-link text="Add to Cart" icon="shopping-cart" />
                <x-icon-link text="Add to Wishlist" icon="clipboard-list" />
                <x-icon-link text="Message seller" icon="mail-open" />
                <x-icon-link text="Call seller" icon="phone-outgoing" />
                <x-icon-link text="Documents" icon="document-text" />
                <x-icon-link text="Reports" icon="document-report" />
            </nav>
        </x-card>

        <x-card title="Data" class="mt-12">
            <x-data-list>
                <x-data-list-item label="Label" value="Value" />
                <x-data-list-item label="Label" value="Value" />
                <x-data-list-item label="Label" value="Value" />
                <x-data-list-item label="Label" value="Value" />
                <x-data-list-item label="Label" value="Value" />
                <x-data-list-item label="Label" value="Value" />
                <x-data-list-item label="Label" value="Value" />
            </x-data-list>
        </x-card>

        <x-card title="Vehicle List" class="mt-12">
            <x-table class="striped-table">
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-8">
                        Select
                    </x-table.heading>
                    <x-table.heading>Model</x-table.heading>
                    <x-table.heading>Vin</x-table.heading>
                    <x-table.heading>Origin</x-table.heading>
                    <x-table.heading>Brand</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            Selected
                        </x-table.cell>
                        <x-table.cell>
                            Model
                        </x-table.cell>
                        <x-table.cell>
                            VIN
                        </x-table.cell>
                        <x-table.cell>
                            Origin
                        </x-table.cell>
                        <x-table.cell>
                            Brand
                        </x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            Selected
                        </x-table.cell>
                        <x-table.cell>
                            Model
                        </x-table.cell>
                        <x-table.cell>
                            VIN
                        </x-table.cell>
                        <x-table.cell>
                            Origin
                        </x-table.cell>
                        <x-table.cell>
                            Brand
                        </x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            Selected
                        </x-table.cell>
                        <x-table.cell>
                            Model
                        </x-table.cell>
                        <x-table.cell>
                            VIN
                        </x-table.cell>
                        <x-table.cell>
                            Origin
                        </x-table.cell>
                        <x-table.cell>
                            Brand
                        </x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            Selected
                        </x-table.cell>
                        <x-table.cell>
                            Model
                        </x-table.cell>
                        <x-table.cell>
                            VIN
                        </x-table.cell>
                        <x-table.cell>
                            Origin
                        </x-table.cell>
                        <x-table.cell>
                            Brand
                        </x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            Selected
                        </x-table.cell>
                        <x-table.cell>
                            Model
                        </x-table.cell>
                        <x-table.cell>
                            VIN
                        </x-table.cell>
                        <x-table.cell>
                            Origin
                        </x-table.cell>
                        <x-table.cell>
                            Brand
                        </x-table.cell>
                    </x-table.row>
                </x-slot>
            </x-table>
        </x-card>
    </div>
    <div class="pt-12">
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-3xl leading-6 font-medium text-gray-900">
                Flows
            </h1>
        </div>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-xl leading-6 font-medium text-gray-900">
                Enquiry
            </h1>
        </div>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4">
                Step 1: Overview of selected vehicles with CTA to start the enquiry
            </h1>
        </div>

        <x-columns widths="wide-narrow">
            <x-slot name="wide">
                <x-card title="Vehicle List">
                    <x-table class="striped-table">
                        <x-slot name="head">
                            <x-table.heading class="pr-0 w-8">
                                Remove
                            </x-table.heading>
                            <x-table.heading>Model</x-table.heading>
                            <x-table.heading>Vin</x-table.heading>
                            <x-table.heading>Origin</x-table.heading>
                            <x-table.heading>Brand</x-table.heading>
                        </x-slot>

                        <x-slot name="body">
                            <x-table.row>
                                <x-table.cell class="pr-0">
                                    <x-heroicon-s-minus-circle
                                        class="text-red-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                                </x-table.cell>
                                <x-table.cell>
                                    Model
                                </x-table.cell>
                                <x-table.cell>
                                    VIN
                                </x-table.cell>
                                <x-table.cell>
                                    Origin
                                </x-table.cell>
                                <x-table.cell>
                                    Brand
                                </x-table.cell>
                            </x-table.row>
                            <x-table.row>
                                <x-table.cell class="pr-0">
                                    <x-heroicon-s-minus-circle
                                        class="text-red-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                                </x-table.cell>
                                <x-table.cell>
                                    Model
                                </x-table.cell>
                                <x-table.cell>
                                    VIN
                                </x-table.cell>
                                <x-table.cell>
                                    Origin
                                </x-table.cell>
                                <x-table.cell>
                                    Brand
                                </x-table.cell>
                            </x-table.row>
                            <x-table.row>
                                <x-table.cell class="pr-0">
                                    <x-heroicon-s-minus-circle
                                        class="text-red-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                                </x-table.cell>
                                <x-table.cell>
                                    Model
                                </x-table.cell>
                                <x-table.cell>
                                    VIN
                                </x-table.cell>
                                <x-table.cell>
                                    Origin
                                </x-table.cell>
                                <x-table.cell>
                                    Brand
                                </x-table.cell>
                            </x-table.row>
                            <x-table.row>
                                <x-table.cell class="pr-0">
                                    <x-heroicon-s-minus-circle
                                        class="text-red-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                                </x-table.cell>
                                <x-table.cell>
                                    Model
                                </x-table.cell>
                                <x-table.cell>
                                    VIN
                                </x-table.cell>
                                <x-table.cell>
                                    Origin
                                </x-table.cell>
                                <x-table.cell>
                                    Brand
                                </x-table.cell>
                            </x-table.row>
                            <x-table.row>
                                <x-table.cell class="pr-0">
                                    <x-heroicon-s-minus-circle
                                        class="text-red-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                                </x-table.cell>
                                <x-table.cell>
                                    Model
                                </x-table.cell>
                                <x-table.cell>
                                    VIN
                                </x-table.cell>
                                <x-table.cell>
                                    Origin
                                </x-table.cell>
                                <x-table.cell>
                                    Brand
                                </x-table.cell>
                            </x-table.row>
                        </x-slot>
                    </x-table>
                </x-card>
            </x-slot>
            <x-slot name="narrow">
                <x-card title="Actions">
                    <nav class="space-y-1" aria-label="Sidebar">
                        <x-icon-link text="Start Enquiry" icon="arrow-circle-right" class="" />
                    </nav>
                </x-card>
            </x-slot>
        </x-columns>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4 mt-6">
                Step 2: Summary of enquired vehicles
            </h1>
        </div>
        <x-card title="Summary">
            <p class="pb-6">The enquiry has been sent and the seller will contact you shortly. Following vehicles have been enquired:</p>
                <x-table class="striped-table pt-12">
                    <x-slot name="head">
                        <x-table.heading class="pr-0 w-8">
                            Select
                        </x-table.heading>
                        <x-table.heading>Model</x-table.heading>
                        <x-table.heading>Vin</x-table.heading>
                        <x-table.heading>Origin</x-table.heading>
                        <x-table.heading>Brand</x-table.heading>
                    </x-slot>

                    <x-slot name="body">
                        <x-table.row>
                            <x-table.cell class="pr-0">
                                Under review
                            </x-table.cell>
                            <x-table.cell>
                                Model
                            </x-table.cell>
                            <x-table.cell>
                                VIN
                            </x-table.cell>
                            <x-table.cell>
                                Origin
                            </x-table.cell>
                            <x-table.cell>
                                Brand
                            </x-table.cell>
                        </x-table.row>
                        <x-table.row>
                            <x-table.cell class="pr-0">
                                Under review
                            </x-table.cell>
                            <x-table.cell>
                                Model
                            </x-table.cell>
                            <x-table.cell>
                                VIN
                            </x-table.cell>
                            <x-table.cell>
                                Origin
                            </x-table.cell>
                            <x-table.cell>
                                Brand
                            </x-table.cell>
                        </x-table.row>
                        <x-table.row>
                            <x-table.cell class="pr-0">
                                Under review
                            </x-table.cell>
                            <x-table.cell>
                                Model
                            </x-table.cell>
                            <x-table.cell>
                                VIN
                            </x-table.cell>
                            <x-table.cell>
                                Origin
                            </x-table.cell>
                            <x-table.cell>
                                Brand
                            </x-table.cell>
                        </x-table.row>
                        <x-table.row>
                            <x-table.cell class="pr-0">
                                Under review
                            </x-table.cell>
                            <x-table.cell>
                                Model
                            </x-table.cell>
                            <x-table.cell>
                                VIN
                            </x-table.cell>
                            <x-table.cell>
                                Origin
                            </x-table.cell>
                            <x-table.cell>
                                Brand
                            </x-table.cell>
                        </x-table.row>
                        <x-table.row>
                            <x-table.cell class="pr-0">
                                Under review
                            </x-table.cell>
                            <x-table.cell>
                                Model
                            </x-table.cell>
                            <x-table.cell>
                                VIN
                            </x-table.cell>
                            <x-table.cell>
                                Origin
                            </x-table.cell>
                            <x-table.cell>
                                Brand
                            </x-table.cell>
                        </x-table.row>
                    </x-slot>
                </x-table>
        </x-card>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4 mt-6">
                Step 3: E-mail to seller
            </h1>
        </div>
        <x-card title="Enquiry Started">
            {{ (new \App\Notifications\EnquiryStarted())->toMail('seller@carmarket.io')->render() }}
        </x-card>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4 mt-6">
                Step 4: View enquiries
            </h1>
        </div>
        <x-card title="Enquiry Inbox">
            <x-table class="striped-table">
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-8">
                        #
                    </x-table.heading>
                    <x-table.heading>Model</x-table.heading>
                    <x-table.heading>Vin</x-table.heading>
                    <x-table.heading>Origin</x-table.heading>
                    <x-table.heading>Brand</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            0001
                        </x-table.cell>
                        <x-table.cell>
                            Model
                        </x-table.cell>
                        <x-table.cell>
                            VIN
                        </x-table.cell>
                        <x-table.cell>
                            Origin
                        </x-table.cell>
                        <x-table.cell>
                            Brand
                        </x-table.cell>
                    </x-table.row>
                </x-slot>
            </x-table>
        </x-card>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4 mt-6">
                Step 5a: Transaction accepted
            </h1>
        </div>
        <x-card title="Transaction accepted">
            {{ (new \App\Notifications\TransactionAccepted())->toMail('buyer@carmarket.io')->render() }}
        </x-card>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4 mt-6">
                Step 5b: Transaction declined
            </h1>
        </div>
        <x-card title="Transaction declined">
            {{ (new \App\Notifications\TransactionDeclined())->toMail('buyer@carmarket.io')->render() }}
        </x-card>
        <div class="pb-5 mb-6 border-b border-gray-200">
            <h1 class="text-lg leading-6 font-medium text-gray-900 pl-4 mt-6">
                Step 6: Enquiry Inbox
            </h1>
        </div>
        <x-card title="Enquiries">
            <x-table class="striped-table">
                <x-slot name="head">
                    <x-table.heading class="pr-0 w-8">Date</x-table.heading>
                    <x-table.heading>Vehicles</x-table.heading>
                    <x-table.heading>Status</x-table.heading>
                </x-slot>

                <x-slot name="body">
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            2020-01-05
                        </x-table.cell>
                        <x-table.cell>
                            3 vehicles
                        </x-table.cell>
                        <x-table.cell>
                            <x-heroicon-s-thumb-up
                                                 class="text-green-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                        </x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            2020-01-05
                        </x-table.cell>
                        <x-table.cell>
                            3 vehicles
                        </x-table.cell>
                        <x-table.cell>
                            <x-heroicon-s-cog
                                class="text-yellow-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6 animate-spin duration-2000"/>
                        </x-table.cell>
                    </x-table.row>
                    <x-table.row>
                        <x-table.cell class="pr-0">
                            2020-01-05
                        </x-table.cell>
                        <x-table.cell>
                            3 vehicles
                        </x-table.cell>
                        <x-table.cell>
                            <x-heroicon-s-thumb-down
                                class="text-red-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6"/>
                        </x-table.cell>
                    </x-table.row>

                </x-slot>
            </x-table>
        </x-card>


    </div>
</div>
