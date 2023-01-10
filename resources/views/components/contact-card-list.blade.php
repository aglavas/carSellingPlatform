<ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
    @foreach($users as $user)
        <li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
            <x-contact-card :user="$user" />
        </li>
    @endforeach
</ul>
