<x-app-layout >

    <div class="container d-flex flex-column align-items-center mb-5">
        <h2 class="my-5 text-center ms_font-color">
            {{ __('Profile of') }} {{ Auth::user()->name }} {{ Auth::user()->lastname }}
        </h2>

        <div class="py-12 col-12 col-md-8 col-lg-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 ms_bg-card  shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8  ms_bg-card  shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 sm:p-8  ms_bg-card  shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
