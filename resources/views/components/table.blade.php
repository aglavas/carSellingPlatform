<div class="flex flex-col">
    <div class="-my-2">
        <div class="py-2 align-middle inline-block min-w-full">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table {{ $attributes->merge(['class' => 'min-w-full divide-y divide-gray-200']) }}>
                    <thead class="bg-gray-50">
                    <tr>
                        {{ $head }}
                    </tr>
                    </thead>
                    <tbody>
                        {{ $body }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
