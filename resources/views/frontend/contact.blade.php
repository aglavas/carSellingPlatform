<x-frontend.layouts.app>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-slot name="pageTitle">
            Contact
        </x-slot>
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('contact.store') }}" method="post">
                @csrf
                <div class="space-y-8">
                    <div>
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Questions?
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Use the below field to ask a question not covered by the <a href="/carmarket_manual_13082020.pdf" class="text-blue-500 underline" target="_blank">manual</a> or instructions. Feedback is also very much welcomed.
                            </p>
                        </div>

                        <div class="mt-6 grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="message" class="block text-sm font-medium text-gray-700">
                                    Message
                                </label>
                                <div class="mt-1">
                                    <textarea id="message" name="message" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5">
                    <div class="flex justify-end">
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Send
                            @svg('heroicon-s-arrow-circle-right', ['class' => 'text-white group-hover:text-gray-100 ml-1 h-5 w-5'])
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-frontend.layouts.app>

