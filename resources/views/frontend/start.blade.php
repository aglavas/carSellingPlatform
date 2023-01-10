<livewire:announcement-banner/>
<x-frontend.layouts.app>
    <x-slot name="pageTitle">
        Start
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8 pb-10 pt-12">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
    </div>
    <br>
    <livewire:change-notification/>
    <livewire:dashboard-panels/>
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <livewire:new-user-list/>
    @endif
</x-frontend.layouts.app>

