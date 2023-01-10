<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                User Profile
            </h3>
            <form wire:submit.prevent="submit">
                <div class="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-center sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="photo" class="block text-sm font-medium text-gray-700">
                            Photo
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                              <span class="h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                  <img src="{{ auth()->user()->avatarUrl() }}" alt="Profile Photo">
                              </span>
                                <span class="ml-5">
                                <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file" id="avatar" wire:model="avatar">
                                    <label for="avatar" :class="{ 'outline-none border-blue-300 shadow-outline-blue': focused }" class="cursor-pointer py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
                                        Select File
                                    </label>
                                @error('avatar') <span class="text-danger">{{ $message }}</span> @enderror
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="text" wire:model="name" name="name" id="name" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('name'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('name') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Email
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="text" wire:model="email" name="email" id="email" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('email'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('email') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="password" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Password
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="password" wire:model="password" name="password" id="password" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('password'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('passwoord') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="country" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Country
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="country" disabled name="country" autocomplete="country" class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                @foreach($this->countries as $countryCode => $countryName)
                                    @if ($country === $countryCode)
                                        <option wire:click="setState('country', '{{ $countryCode }}')" value="{{ $countryCode }}" selected="true"> {{ $countryName }}</option>
                                    @else
                                        <option wire:click="setState('country', '{{ $countryCode }}')" value="{{ $countryCode }}"> {{ $countryName }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="company" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Company
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="company" disabled name="company" class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                @foreach($this->companies as $companyId => $companyName)
                                    @if ($company == $companyId)
                                        <option wire:click="setState('company', '{{ $companyId }}')" value="{{ $companyId }}" selected="true"> {{ $companyName }}</option>
                                    @else
                                        <option wire:click="setState('company', '{{ $companyId }}')" value="{{ $companyId }}"> {{ $companyName }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="function" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Function
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="text" wire:model="function" name="function" id="function" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('function'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('function') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="telephone" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Telephone
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="text" wire:model="telephone" name="telephone" id="telephone" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('telephone'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('telephone') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="mobile" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Mobile
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="text" wire:model="mobile" name="mobile" id="mobile" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('mobile'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('mobile') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="stock_type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Stock Type
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="stock_type" disabled name="stock_type" class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                @foreach($this->stock as $stockCode => $stock)
                                    @if ($stockType === $stockCode)
                                        <option wire:click="setState('stockType', '{{ $stockCode }}')" value="{{ $stockCode }}" selected="true"> {{ $stock }}</option>
                                    @else
                                        <option wire:click="setState('stockType', '{{ $stockCode }}')" value="{{ $stockCode }}"> {{ $stock }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="import_type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Import Type
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <select id="import_type" disabled="" name="import_type" autocomplete="country" class="max-w-lg block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md">
                                @foreach($this->import as $importCode => $import)
                                    @if ($importType === $importCode)
                                        <option wire:click="setState('importType', '{{ $importCode }}')" value="{{ $importCode }}" selected="true"> {{ $import }}</option>
                                    @else
                                        <option wire:click="setState('importType', '{{ $importCode }}')" value="{{ $importCode }}"> {{ $import }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:grid sm:grid-cols-4 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                        <label for="token" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Api Token
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                <input type="text" wire:model="token" disabled name="token" id="token" class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                            @if ($errors->has('token'))
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-lg" role="alert">
                                    <strong class="font-bold">Validation error.</strong>
                                    <span class="block sm:inline">{{ $errors->first('token') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </div>
                </div>
                <span x-data="{ open: false }" x-init="
                        @this.on('notify-saved', () => {
                            if (open === false) setTimeout(() => { open = false }, 2500);
                            open = true;
                        })
                    " x-show.transition.out.duration.1000ms="open" style="display: none;" class="text-gray-500">
                        <div class="rounded-lg shadow-xs overflow-hidden">
                            <div class="max-w-sm w-full bg-green-200 text-green-900 shadow-lg rounded-lg pointer-events-auto p-4">
                                <div class="flex items-start">
                                    <div class="ml-3 w-0 flex-1 pt-0.5">
                                        <p class="text-sm leading-5 font-medium text-gray-900">
                                            Saved
                                        </p>
                                    </div>
                                    <div class="ml-4 flex-shrink-0 flex">
                                        <button @click="show = false" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                            <x-icon-link text="" icon="x-circle" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </span>
            </form>
        </div>
    </div>
</div>
