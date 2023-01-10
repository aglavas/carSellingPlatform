<div
    class="fixed inset-0 overflow-hidden z-50 w-96"
    aria-labelledby="slide-over-title"
    role="dialog"
    aria-modal="true"
    x-data="{ mobileNav: false }"
    x-show="mobileNav"
    @open-dropdown.window="if ($event.detail.id == 999) mobileNav = !mobileNav"
    @click.away="mobileNav = false"
    id="mobileNav"
    x-cloak
>
    <div class="absolute inset-0 overflow-hidden">
        <!-- Background overlay, show/hide based on slide-over state. -->
        <div class="absolute inset-y-0" aria-hidden="true">
            <div class="fixed inset-y-0 right-0 pr-10 max-w-full flex top-36">
                <div x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:enter-start="translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="translate-x-full"
                     class="w-screen max-w-md"
                    >
                    <div class="h-full flex flex-col py-6 bg-white shadow-xl overflow-y-scroll">
                        <div class="group inline-block">
                            <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                <span class="pr-1 font-semibold flex-1">Vehicles</span>
                                <span>
                                         <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                         </svg>
                                    </span>
                            </button>
                            <ul class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute transition duration-150 ease-in-out origin-top min-w-32 w-full z-20">
                                <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('vehicle-search', ['type' => 'all']) }}">All Cars</a></li>
                                <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('vehicle-search', ['type' => 'used']) }}">Used Cars</a></li>
                                <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('vehicle-search', ['type' => 'new']) }}">New Cars</a></li>
                            </ul>
                        </div>
                        <div class="group inline-block">
                            <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                <span class="pr-1 font-semibold flex-1">Enquiries</span>
                                <span>
                                         <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                         </svg>
                                    </span>
                            </button>
                            <ul class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute transition duration-150 ease-in-out origin-top min-w-32 w-full z-20">
                                @if(\Illuminate\Support\Facades\Auth::user()->isBuyerAndSeller())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('enquiry.list', ['userType' => 'buyer', 'status' => ['in_progress']]) }}">My Requests</a></li>
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('enquiry.list', ['userType' => 'seller', 'status' => ['in_progress']]) }}">Buying Requests</a></li>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->isSeller())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('enquiry.list', ['userType' => 'seller', 'status' => ['in_progress']]) }}">Buying Requests</a></li>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyer())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('enquiry.list', ['userType' => 'buyer', 'status' => ['in_progress']]) }}">My Requests</a></li>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('enquiry.list', ['userType' => 'buyer', 'status' => ['in_progress']]) }}">My Requests</a></li>
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('enquiry.list', ['userType' => 'seller', 'status' => ['in_progress']]) }}">Buying Requests</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="group inline-block">
                            <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                <span class="pr-1 font-semibold flex-1">Orders</span>
                                <span>
                                         <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                         </svg>
                                    </span>
                            </button>
                            <ul class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute transition duration-150 ease-in-out origin-top min-w-32 w-full z-20">
                                @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'admin', 'status' => ['approved']]) }}">All Orders</a></li>
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}">My Requests</a></li>
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}">Buying Requests</a></li>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyerAndSeller())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}">My Requests</a></li>
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}">Buying Requests</a></li>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->isSeller())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'seller', 'status' => ['approved']]) }}">Buying Requests</a></li>
                                @elseif(\Illuminate\Support\Facades\Auth::user()->isBuyer())
                                    <li class="px-3 py-1 hover:bg-gray-100"><a href="{{ route('order.list', ['userType' => 'buyer', 'status' => ['approved']]) }}">My Requests</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="group inline-block">
                            <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                <span class="pr-1 font-semibold flex-1"><a href="{{ route('user-profile') }}">Profile</a></span>
                            </button>
                        </div>
                        @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                            <div class="group inline-block">
                                <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                    <span class="pr-1 font-semibold flex-1"><a href="{{ route('analytics', ['type' => 'dashboard']) }}">Analytics</a></span>
                                </button>
                            </div>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->isSeller() || \Illuminate\Support\Facades\Auth::user()->isAdmin())
                            <div class="group inline-block">
                                <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                    <span class="pr-1 font-semibold flex-1"><a href="{{ route('car.upload') }}">Upload</a></span>
                                </button>
                            </div>
                        @endif
                        @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                            <div class="group inline-block">
                                <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                    <span class="pr-1 font-semibold flex-1"><a href="{{ route('nova.login') }}">Admin Panel</a></span>
                                </button>
                            </div>
                        @endif
                        <div class="group inline-block">
                            <button class="outline-none focus:outline-none border px-3 py-1 bg-white rounded-sm flex items-center min-w-32 w-full">
                                <span class="pr-1 font-semibold flex-1"><a href="{{ route('nova.logout') }}">Sign Out</a></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
