@if($widths == "wide-narrow")
    <div class="mt-8 mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-3">
        <div class="space-y-6 lg:col-start-1 lg:col-span-2">
            <section aria-labelledby="column-1">
                {{ $wide }}
            </section>
        </div>

        <section aria-labelledby="column-2" class="lg:col-start-3 lg:col-span-1">
            {{ $narrow }}
        </section>
    </div>
@endif

@if($widths == "narrow-wide")
    <div class="mt-8 mx-auto grid grid-cols-1 gap-6 sm:px-6 lg:grid-flow-col-dense lg:grid-cols-4">
        <div class="space-y-6 lg:col-start-1 lg:col-span-1">
            <section aria-labelledby="column-1">
                {{ $narrow }}
            </section>
        </div>

        <section aria-labelledby="column-2" class="lg:col-start-2 lg:col-span-3">
            {{ $wide }}
        </section>
    </div>
@endif
