@if ($show)
<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
    <div class="rounded-md bg-yellow-50 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <!-- Heroicon name: solid/x-circle -->
                <svg class="h-5 w-5 text-yellow-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">
                    There were {{ $totalCount }} changes since your last login
                </h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @if ($approved > 0)
                            <li>
                                {{ $approved }} vehicles got approved. <span wire:click="viewChanges('{{ route('order.list', ['userType' => 'buyer']) }}')" class="font-bold clickable underline">Show</span>
                            </li>
                        @endif
                        @if ($denied > 0)
                            <li>
                                {{ $denied }} vehicles got declined <span wire:click="viewChanges('{{ route('enquiry.list', ['userType' => 'buyer']) }}')" class="font-bold clickable underline">Show</span>
                            </li>
                        @endif
                        @if ($enquiries > 0)
                            <li>
                                {{ $enquiries }} new enquiries <span wire:click="viewChanges('{{ route('enquiry.list', ['userType' => 'seller']) }}')" class="font-bold clickable underline">Show</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="flex-grow text-right">
                <button wire:click="markAsSeen" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                    @svg('heroicon-s-x-circle', ['class' => 'text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 mt-4 h-6 w-6'])
                </button>
            </div>
        </div>
    </div>
</div>
@endif
