<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <ul class="divide-y divide-gray-200">
        @foreach($users as $user)
            <li>
                <a href="#" class="block hover:bg-gray-50">
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="min-w-0 flex-1 flex items-center">
                            {{--
                            <div class="flex-shrink-0">
                                <img class="h-12 w-12" src="{{ asset('images/flags/'.$user->country.'.svg') }}" alt="">
                            </div>
                            --}}
                            <div class="min-w-0 flex-1 px-4 md:grid md:grid-cols-1 md:gap-4">
                                <div>
                                    <p class="text-sm font-medium text-blue-600 truncate">{{ $user->name }}</p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500">
                                        <!-- Heroicon name: mail -->
                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                        <span class="truncate"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></span>
                                    @if ($user->telephone)
                                        <div class="hidden md:block">
                                                <p class="mt-2 flex items-center text-sm text-gray-500">
                                                    <!-- Heroicon name: check-circle -->
                                                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                                    </svg>
                                                    <span class="ml-3"><a href="tel:{{ $user->telephone }}">{{ $user->telephone }}</a></span>
                                                </p>
                                        </div>
                                    @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </li>
        @endforeach
    </ul>
</div>
