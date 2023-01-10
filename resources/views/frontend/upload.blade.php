<x-frontend.layouts.app>
    <div class="pt-6 pb-2 max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900" data-config-id="01_c_header">Upload your vehicles</h1>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4" data-bucket="1">
            @if ($upload->status == 1)
                <div data-section-id="6" data-category="ap-fe-alerts" data-component-id="9646_109_04_awz" data-custom-component-id="52390">
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm leading-5 font-medium text-green-800">Successfully uploaded</p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5">
                                    <button class="inline-flex rounded-md p-1.5 text-green-500 hover:bg-green-100 focus:outline-none focus:bg-green-100 transition ease-in-out duration-150">
                                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                </div>
            @else
                <div data-section-id="4" data-category="ap-fe-alerts" data-component-id="9646_109_06_awz" data-custom-component-id="52344">
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm leading-5 font-medium text-red-800">Errors</h3>
                                <div class="mt-2 text-sm leading-5 text-red-700">
                                    <ul class="list-disc pl-5">
                                        <li>Some cars have not been uploaded, please check the status field below.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                </div>
            @endif

            <div data-section-id="5" data-category="ap-da-description-lists" data-component-id="9646_102_01_awz" data-custom-component-id="52348" class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Upload Summary</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-5 text-gray-500"></p>
                </div>
                <div class="px-4 py-5 sm:p-0">
                    <dl>
                        <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:py-5"><dt class="text-sm leading-5 font-medium text-gray-500">ID</dt><dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">{{ $upload->id }}</dd></div>
                        <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"><dt class="text-sm leading-5 font-medium text-gray-500">List Type</dt><dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">{{ $upload->list_type }}</dd></div>
                        <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"><dt class="text-sm leading-5 font-medium text-gray-500">Total Errors</dt><dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">{{ $upload->totalErrors }}</dd></div>
                        <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"><dt class="text-sm leading-5 font-medium text-gray-500">Country</dt><dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">{{ $upload->country }}</dd></div>
                        <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5"><dt class="text-sm leading-5 font-medium text-gray-500">Errors</dt><dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                @if ($upload->status == 1)
                                    No errors
                                @else
                                    {!! $upload->status !!}
                                @endif
                            </dd></div>
                        <div class="mt-8 sm:mt-0 sm:grid sm:grid-cols-3 sm:gap-4 sm:border-t sm:border-gray-200 sm:px-6 sm:py-5">
                            <dt class="text-sm leading-5 font-medium text-gray-500">Attachments</dt>
                            <dd class="mt-1 text-sm leading-5 text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="border border-gray-200 rounded-md">
                                    <li class="border-t border-gray-200 pl-3 pr-4 py-3 flex items-center justify-between text-sm leading-5">
                                        <div class="w-0 flex-1 flex items-center">
                                            <span class="ml-2 flex-1 w-0 truncate">{{ $upload->file_path }}</span>
                                        </div>
                                        <div class="ml-4 flex-shrink-0"><a class="font-medium text-indigo-600 hover:text-indigo-500 transition duration-150 ease-in-out" href="{{ Storage::url($upload->file_path) }}" download>Download</a></div>
                                    </li>
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-frontend.layouts.app>
