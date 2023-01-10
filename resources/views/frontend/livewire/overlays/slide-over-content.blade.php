<div>
    @if($content)
        <section x-data
                 @click.away="$wire.closeSlideOver()"
                 class="absolute inset-y-0 right-0 pl-10 max-w-full flex z-20" aria-labelledby="slide-over-heading"
                 x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
        >
            <div class="w-screen max-w-lg">
                {!! $content !!}
            </div>
        </section>
    @endif
</div>
