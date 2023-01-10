<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<body id="page" class="font-sans antialiased text-gray-900">
<div class="" id="content">
    <div data-section-id="1" data-category="ma-se-contact" data-component-id="9646_134_05_awz" data-custom-component-id="67462" class="relative bg-white">
        <div class="lg:absolute lg:inset-0">
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2"><img class="h-56 w-full object-cover lg:absolute lg:h-full" src="https://images.unsplash.com/photo-1543465077-db45d34b88a5?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2201&q=80" alt=""></div>
        </div>
        <div class="relative pt-12 pb-16 px-4 sm:pt-16 sm:px-6 lg:px-8 lg:max-w-7xl lg:mx-auto lg:grid lg:grid-cols-2">
            <div class="lg:pr-8">
                <div class="max-w-md mx-auto sm:max-w-lg lg:mx-0">
                    <h2 class="text-3xl leading-9 font-extrabold tracking-tight sm:text-4xl sm:leading-10"><strong>carmarket</strong> - Let's share cars</h2>
                    <p class="mt-4 text-lg leading-7 text-gray-500 sm:mt-3">You got invited to carmarket, so you want access to all the internal vehicles.</p>
                    <form class="mt-9 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8" action="{{ route('nova.register.store') }}" method="POST">
                        <hr>
                        <div class="sm:col-span-2">
                            <label class="block mb-2 text-xs text-gray-700 uppercase tracking-wide font-bold">MY PROFILE</label>
                        </div>
                        @csrf
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="name">Name</label>
                                <span class="text-sm font-strong text-yellow-500">Required</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="name" name="name" type="text" autocomplete="Name" value="{{ old('name') }}">
                            </div>
                            @error('name')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="email">Work Email</label>
                                <span class="text-sm font-strong text-yellow-500">Required</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="email" name="email" type="email" autocomplete="Email" value="{{ old('email') }}">
                            </div>
                            @error('email')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="password">Password</label>
                                <span class="text-sm font-strong text-yellow-500">Required</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="email" name="password" type="password" autocomplete="Password">
                            </div>
                            @error('password')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="password-confirmation">Re-type password</label>
                                <span class="text-sm font-strong text-yellow-500">Required</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="email" name="password_confirmation" type="password" autocomplete="Retype password">
                            </div>
                        </div>
                        <livewire:company-search/>
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="function">Function</label>
                                <span class="text-sm text-gray-500" id="phone_description">Optional</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="company" type="text" name="function_description" autocomplete="Function description" value="{{ old('function_description') }}">
                            </div>
                            @error('function_description')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="phone">Phone</label>
                                <span class="text-sm text-gray-500" id="phone_description">Optional</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="phone" type="text" name="telephone" autocomplete="tel" aria-describedby="phone_description" value="{{ old('telephone') }}">
                            </div>
                            @error('telephone')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <div class="flex justify-between">
                                <label class="block text-sm font-medium text-gray-700" for="mobile">Mobile</label>
                                <span class="text-sm text-gray-500" id="phone_description">Optional</span>
                            </div>
                            <div class="mt-1">
                                <input class="block w-full shadow-sm sm:text-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md" id="company" type="text" name="mobile" autocomplete="organization" value="{{ old('mobile') }}">
                            </div>
                            @error('mobile')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <hr>
                        <div class="sm:col-span-2">
                            <label class="block mb-2 text-xs text-gray-700 uppercase tracking-wide font-bold">MY SETTINGS</label>
                        </div>
                        <livewire:stock-type-selection/>
                        <div class="sm:col-span-2">
                            <legend class="block text-sm font-medium text-gray-700 font-bold">Choose your roles</legend>
                            <legend class="block text-sm font-small text-gray-700">Please pick your roles within Carmarket platform.</legend>
                            <div class="mt-4 grid grid-cols-1 gap-y-4">
                                @foreach($roles as $roleId => $roleName)
                                    <div class="flex items-center">
                                        @if ($roleName === 'Buyer')
                                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="role[]" value="{{ $roleId }}" type="checkbox" checked disabled>
                                            <input name="role[]" value="{{ $roleId }}" type="hidden">
                                        @else
                                            @if (in_array($roleId, old('role', [])))
                                                <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="role[]" value="{{ $roleId }}" type="checkbox" checked>
                                            @else
                                                <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="role[]" value="{{ $roleId }}" type="checkbox">
                                            @endif
                                        @endif
                                        <label class="ml-3" for="budget_under_25k"> <span class="block text-sm text-gray-700">{{ $roleName }} {{ \Illuminate\Support\Facades\Config::get("carmarket.role_label." . $roleName ) }}</span> </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('role')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <livewire:brand-selection :brands="$brands"/>
                        @error('brand')
                        <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                            <p><strong>{{ $message }}</strong></p>
                        </div>
                        @enderror
                        <div class="sm:col-span-2">
                            <legend class="block text-sm font-medium text-gray-700 font-bold">Vehicle Types</legend>
                            <div class="mt-4 grid grid-cols-1 gap-y-4">
                                @foreach($vehicleTypes as $type => $name)
                                    <div class="flex items-center">
                                        @if (in_array($type, old('vehicle_type', [])))
                                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="vehicle_type[]" value="{{ $type }}" type="checkbox" checked>
                                        @else
                                            <input class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" name="vehicle_type[]" value="{{ $type }}" type="checkbox">
                                        @endif
                                        <label class="ml-3" for="budget_under_25k"><span class="block text-sm text-gray-700">{{ $name }}</span></label>
                                    </div>
                                @endforeach
                            </div>
                            @error('vehicle_type')
                            <div class="relative py-3 pl-4 pr-10 leading-normal text-red-700 bg-red-100 rounded-lg" role="alert">
                                <p><strong>{{ $message }}</strong></p>
                            </div>
                            @enderror
                        </div>
                        <div class="text-right sm:col-span-2">
                            <button class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@livewireScripts
</body>
