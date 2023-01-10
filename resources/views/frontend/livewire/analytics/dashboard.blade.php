<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <x-slot name="pageTitle">
        Analytics
    </x-slot>
    <div class="container mx-auto px-4 mb-4">
        <label class="block mb-2 text-xs text-gray-700 uppercase tracking-wide font-bold">Period select</label>
        <select wire:change="setPeriod($event.target.value)" class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none">
            <option value="all">All</option>
            <option value="this-year">This year</option>
            <option value="last-year">Last year</option>
            <option value="this-month">This month</option>
            <option value="last-month">Last month</option>
            <option value="this-week">This week</option>
            <option value="last-week">Last week</option>
        </select>
    </div>
        <div>
            <livewire:analytics.scorecards :period="$period" key="{{ now() }}"/>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <livewire:analytics.cars-by-country :period="$period" key="{{ now() }}"/>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                <div>
                    <livewire:analytics.used-new-car-count-overtime :period="$period" key="{{ now() }}"/>
                </div>
            @endif
            <div>
                <livewire:analytics.used-cars-by-brand-bar :period="$period" key="{{ now() }}"/>
            </div>
            <div>
                <livewire:analytics.new-cars-by-brand-bar :period="$period" key="{{ now() }}"/>
            </div>
            @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                <div>
                    <livewire:analytics.used-cars-per-country-over-time :period="$period" key="{{ now() }}"/>
                </div>
                <div>
                    <livewire:analytics.new-cars-per-country-over-time :period="$period" key="{{ now() }}"/>
                </div>
                <div>
                    <livewire:analytics.average-price-used-cars-over-time :period="$period" key="{{ now() }}"/>
                </div>
            @endif
            <div>
                <livewire:analytics.p-c-d-by-country-bar :period="$period" key="{{ now() }}"/>
            </div>
            <div>
                <livewire:analytics.used-cars-by-mileage :period="$period" key="{{ now() }}"/>
            </div>
            <div>
                <livewire:analytics.f-c-a-by-country-bar :period="$period" key="{{ now() }}"/>
            </div>
            <div>
                <livewire:analytics.used-cars-by-fuel :period="$period" key="{{ now() }}"/>
            </div>
            <div>
                <livewire:analytics.mercedes-by-country-bar :period="$period" key="{{ now() }}"/>
                <livewire:analytics.opel-by-country-bar :period="$period" key="{{ now() }}"/>
            </div>
        </div>
</div>
