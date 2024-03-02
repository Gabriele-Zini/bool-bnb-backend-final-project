<x-app-layout>
    <div class="py-12 d-flex flex-column align-items-center">


            <div class="card ms_bg-card my-5 d-flex justify-content-center fw-bold ms_font-color p-4" style="height: 100px">
                {{ Auth::user()->name }} {{ Auth::user()->lastname }} {{ __("you're logged in!") }}
            </div>
    </div>
</x-app-layout>
