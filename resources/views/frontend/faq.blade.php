<x-frontend.layouts.app>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-slot name="pageTitle">
            Instructions
        </x-slot>
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="prose">
                {!! \App\Instruction::first()->content !!}
            </div>
        </div>
        <script type="text/javascript">
            let div = document.getElementsByClassName('prose');
            for (let i = 0; i < div.length; i++) {
                let a = div[i].getElementsByTagName('a');
                for (let j = 0; j < a.length; j++) {
                    let elem = a[j]
                    elem.target = '_blank'
                    elem.style.color = "#DB2777";
                }
            }
        </script>
    </div>
</x-frontend.layouts.app>

