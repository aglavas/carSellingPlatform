<x-frontend.layouts.app>
    <div class="pt-6 pb-2 max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <h1 class="text-2xl font-semibold text-gray-900" data-config-id="01_c_header">List details</h1>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="py-4" data-bucket="1">
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
