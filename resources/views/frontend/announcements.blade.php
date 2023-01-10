<x-frontend.layouts.app>
    <div class="pt-2 pb-6 md:py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <h1 class="text-2xl font-semibold text-gray-900">Announcements</h1>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
            <div class="py-4">
                <div>
                    <div class="max-w-screen-xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">
                        <hr>
                        <div class="mt-6 border-t-2 border-gray-200 pt-6">
                            <dl>
                                @foreach(\App\Announcement::query()->latest()->get() as $announcement)
                                    <div class="grid grid-cols-2 gap-4 mt-4 mb-4">
                                        <div>
                                            <dt class="text-base leading-6 font-bold text-gray-900 md:col-span-5">{{ $announcement->title }}<span class="font-light"> published {{ $announcement->created_at->format('d.m.Y H:i') }}</span></dt>
                                        </div>
                                        <div class="announcement">
                                            <dd class="mt-2 md:mt-0 md:col-span-7">
                                                <p class="text-base leading-6 text-gray-500">{!! $announcement->content !!}</p>
                                            </dd>
                                        </div>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        let div = document.getElementsByClassName('announcement');
        for (let i = 0; i < div.length; i++) {
            let a = div[i].getElementsByTagName('a');
            for (let j = 0; j < a.length; j++) {
                let elem = a[j]
                elem.style.color = "#DB2777";
            }
        }
    </script>
</x-frontend.layouts.app>
