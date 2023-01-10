@if($show)
    <div class="bg-indigo-600">
        <div class="max-w-screen-xl mx-auto py-3 px-3 sm:px-6 lg:px-8">
            <div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="p-2 rounded-lg bg-indigo-800 w-10 inline-block" style="float: left">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                            </svg>
                        </span>
                        <p class="ml-3 font-medium text-white truncate inline-block pt-2 break-normal">
                            <span>{{ $announcement->title }}</span>
                        </p>
                    </div>
                    <div class="flex text-right justify-end">
                        <div class="order-3 mt-2 flex-shrink-0 sm:order-2 sm:mt-0 sm:w-auto w-24">
                            <div class="rounded-md shadow-sm"><a class="flex items-center justify-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-600 bg-white hover:text-indigo-500 focus:outline-none focus:shadow-outline transition ease-in-out duration-150" wire:click="learnMore">Learn more</a></div>
                        </div>
                        <div class="order-2 flex-shrink-0 sm:order-3 sm:ml-3">
                            <button wire:click="markAsSeen" class="-mr-1 flex p-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:bg-indigo-500 sm:-mr-2 transition ease-in-out duration-150" type="button" aria-label="Dismiss">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
