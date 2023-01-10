<div>
    <div class="flex pt-2">
        <x-form-button :action="route('transaction.deny', $transaction)" class="mr-4 inline-flex items-center shadow-sm px-2.5 py-0.5 border border-red-300 text-sm leading-5 font-medium rounded-full text-red-700 bg-white hover:bg-red-50">
            Deny
        </x-form-button>
        <span class="inline-flex rounded-md shadow-sm">
            <button type="button" wire:click="$emit('showApprovalNotification')" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-green-300 text-sm leading-5 font-medium rounded-full text-green-700 bg-white hover:bg-green-50">
                Approve
            </button>
        </span>
    </div>
    <span x-data="{ open: false }" x-init="
                        @this.on('showApprovalNotification', () => {
                            open = true;
                        })
                    " x-show.transition.out.duration.1000ms="open" style="display: none;" class="text-gray-500">
        <div class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
          <div class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 break-words items-center content-center justify-center justify-items-center"
               x-transition:enter="transform ease-out duration-300 transition"
               x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
               x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
               x-transition:leave="transition ease-in duration-100"
               x-transition:leave-start="opacity-100"
               x-transition:leave-end="opacity-0"
          >
            <div class="p-4">
                <div class="flex items-start">
                    <div class="ml-3 w-0 flex-1 break-words">
                        <p class="mt-1 text-sm text-gray-500 break-words">
                            Agree upon all the details with the buyer,<br>
                            before approving this request.
                        </p>
                      <div class="mt-4 flex">
                          <x-form-button :action="route('transaction.approve', $transaction)" class="bg-green-500 inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Approve Request
                          </x-form-button>
                      </div>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                  <button @click="open = false" class="rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                  </button>
                </div>
            </div>
        </div>
        </div>
    </div>
</span>
</div>

