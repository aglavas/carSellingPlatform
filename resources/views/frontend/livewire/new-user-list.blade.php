<div class="pt-12">
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 mt-3">
    <h1 class="text-2xl font-semibold text-gray-900" data-config-id="01_c_header">We have new users</h1>
</div>
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="flex justify-between pt-6 pb-3">
        <div class="space-x-2 flex items-center pl-6">
            <x-input.select wire:model="perPage" id="perPage">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
            </x-input.select>
        </div>
    </div>
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            @foreach($users as $user)
                <li>
                    <a href="{{ $user->getLink() }}" class="block hover:bg-gray-50">
                        <div class="flex items-center px-4 py-4 sm:px-6">
                            <div class="min-w-0 flex-1 flex items-center">
                                <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-2 md:gap-4">
                                    <div>
                                        <p class="text-sm font-medium text-indigo-600 truncate">{{ $user->name }}</p>
                                        <p class="mt-2 flex items-center text-sm text-gray-500">
                                            <!-- Heroicon name: solid/mail -->
                                            <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            <span class="truncate">{{ $user->email }}</span>
                                        </p>
                                    </div>
                                    <div class="hidden md:block">
                                        <div>
                                            <p class="text-sm text-gray-900">
                                                Applied on
                                                <time datetime="2020-01-07">{{ $user->created_at }}</time>
                                            </p>
                                            <p class="mt-2 flex items-center text-sm text-gray-500">
                                                <!-- Heroicon name: solid/check-circle -->
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $user->function_description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <!-- Heroicon name: solid/chevron-right -->
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    {{ $users->links() }}
</div>
</div>
