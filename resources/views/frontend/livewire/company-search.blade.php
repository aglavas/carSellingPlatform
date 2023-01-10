<div class="sm:col-span-2">
    @if(!$showCompanyFields)
        <div class="mb-3">
            <div class="flex justify-between">
                <label class="block text-sm font-medium text-gray-700" for="company">Company</label>
                <span class="text-sm font-strong text-yellow-500">Required</span>
            </div>
            <select class="appearance-none block w-full py-3 px-4 leading-tight text-gray-700 bg-gray-200 focus:bg-white border border-gray-200 focus:border-gray-500 rounded focus:outline-none" name="company" required>
                @foreach($companies as $companyId => $company)
                    @if ($companyId == old('company', null))
                        <option value="{{ $companyId }}" selected>{{ $company }}</option>
                    @else
                        <option wire:click="selectCompany('{{ $companyId }}')" value="{{ $companyId }}">{{ $company }}</option>
                    @endif
                @endforeach
                    <option wire:click="showCompanyFields" value="XXX">ADD NEW COMPANY</option>
            </select>
            @error('company')
            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                <p><strong>{{ $message }}</strong></p>
            </div>
            @enderror
            @error('company_name')
            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                <p><strong>{{ $message }}</strong></p>
            </div>
            @enderror
            @error('company_address')
            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                <p><strong>{{ $message }}</strong></p>
            </div>
            @enderror
        </div>
    @else
        <div class="mb-3">
            <div class="flex justify-between">
                <label class="block text-sm font-medium text-gray-700" for="company_name">Company Name</label>
                <span class="text-sm font-strong text-yellow-500">Required</span>
            </div>
            <div class="mt-1">
                <input class="block w-full shadow-sm sm:text-sm bg-indigo-200 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" type="text" name="company_name" wire:model="companyName">
            </div>
            @error('company_name')
            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                <p><strong>{{ $message }}</strong></p>
            </div>
            @enderror
        </div>
        <div class="mb-3">
            <div class="flex justify-between">
                <label class="block text-sm font-medium text-gray-700" for="company_address">Company Address</label>
                <span class="text-sm font-strong text-yellow-500">Required</span>
            </div>
            <div class="mt-1">
                <input class="block w-full shadow-sm sm:text-sm bg-indigo-200 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" type="text" name="company_address">
            </div>
            @error('company_address')
            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                <p><strong>{{ $message }}</strong></p>
            </div>
            @enderror
        </div>
    @endif
    <livewire:country-select :country="$country" key="{{ now() }}"/>
</div>
