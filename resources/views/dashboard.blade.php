<x-app-layout>
    <div class="py-12 d-flex flex-column align-items-center">


        <div>
            <div class="fw-bold my-5">
                {{ Auth::user()->name }} {{ Auth::user()->lastname }} {{ __("you're logged in!") }}
            </div>
        </div>
    </div>
</x-app-layout>
