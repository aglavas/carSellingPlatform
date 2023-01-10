<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<body id="page" class="font-sans antialiased">
<div class="" id="content">

    <div data-section-id="1" data-category="ap-fo-sign-in-forms" data-component-id="6577e6a2_03_awz" data-custom-component-id="113440" class="min-h-screen bg-white flex">
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
            <div class="mx-auto w-full max-w-sm">
                <div>
                    <img class="h-12 w-auto" src="https://static.shuffle.dev/uploads/files/8c/8cd7ce74ba0e3450ddda52f8c39f18396ecafac8/carmarket-logo-transparent.png" alt="">
                    <h2 class="mt-6 text-3xl leading-9 font-extrabold text-gray-900">Sign in to your account</h2>
                    <p class="mt-2 text-sm leading-5 text-gray-600 max-w">
                        <span>Or</span>
                        <a class="ml-1 font-medium hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150" style="color: rgba(0, 92, 184, var(--tw-text-opacity));" href="{{ route('nova.register') }}">contact us to create a new account</a>
                    </p>
                </div>
                <div class="mt-8">
                    <div class="mt-6">
                        <form action="{{ route('nova.login') }}" method="POST">
                            {{ csrf_field() }}
                            @if ($errors->any())
                                <p class="text-center font-semibold text-danger my-3">
                                    @if ($errors->has('email'))
                                        {{ $errors->first('email') }}
                                    @else
                                        {{ $errors->first('password') }}
                                    @endif
                                </p>
                            @endif
                            <div>
                                <label class="block text-sm font-medium leading-5 text-gray-700" for="email">Email address</label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" id="email" type="email" name="email" required="" value="{{ old('email') }}">
                                </div>
                            </div>
                            <div class="mt-6">
                                <label class="block text-sm font-medium leading-5 text-gray-700" for="password">Password</label>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <input class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" id="password" type="password" required="" name="password">
                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-between">
                                <div class="flex items-center">
                                    <input class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" id="remember_me" name="remember_me" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="ml-2 block text-sm text-gray-900" for="remember_me">Remember me</label>
                                </div>
                                <div class="text-sm leading-5">
                                    <a class="font-medium focus:outline-none focus:underline transition ease-in-out duration-150" style="color: rgba(0, 92, 184);" href="{{ route('nova.password.request') }}">Forgot your password?</a>
                                </div>
                            </div>
                            <div class="mt-6">
                                <span class="block w-full rounded-md shadow-sm">
                                    <button class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out" style="background-color: rgba(0, 92, 184, var(--tw-bg-opacity));" type="submit">Sign in</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="hidden lg:block relative w-0 flex-1">
            <img class="absolute inset-0 h-full w-full object-cover" src="https://static.shuffle.dev/uploads/files/8c/8cd7ce74ba0e3450ddda52f8c39f18396ecafac8/efag-firmenkunden.jpeg" alt="">
        </div>
    </div>
</div>
@livewireScripts
</body>
