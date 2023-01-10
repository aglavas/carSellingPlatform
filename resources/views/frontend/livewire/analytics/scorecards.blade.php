<div>
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white overflow-hidden shadow rounded-lg ml-3">
                <div class="px-4 py-5 sm:p-6"><dl><dt class="text-sm leading-5 font-medium text-gray-500 truncate">Total Downloads</dt><dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">{{ $downloads }}</dd></dl></div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6"><dl><dt class="text-sm leading-5 font-medium text-gray-500 truncate">Total Uploads</dt><dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">{{ $uploads }}</dd></dl></div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg mr-3">
                <div class="px-4 py-5 sm:p-6"><dl><dt class="text-sm leading-5 font-medium text-gray-500 truncate">Total Transactions</dt><dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">{{ $transactions }}</dd></dl></div>
            </div>
        </div>
    @endif
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white overflow-hidden shadow rounded-lg ml-3 mt-3">
            <div class="px-4 py-5 sm:p-6"><dl><dt class="text-sm leading-5 font-medium text-gray-500 truncate">Total New Cars</dt><dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">{{ $newCars }}</dd></dl></div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg mt-3 mr-3">
            <div class="px-4 py-5 sm:p-6"><dl><dt class="text-sm leading-5 font-medium text-gray-500 truncate">Total Used Cars</dt><dd class="mt-1 text-3xl leading-9 font-semibold text-gray-900">{{ $usedCars }}</dd></dl></div>
        </div>
    </div>
</div>
