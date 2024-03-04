@include('layouts.navigation')

<x-guest-layout>
<div class="container mt-5 d-flex justify-content-center d-flex align-items-center" style="height: 70vh;">

    @vite(['resources/js/app.js'])
    <div class="row justify-content-center w-75">
        <div class=" col-12 col-md-10 col-lg-8 rounded p-5 ms_bg-card" style= "background-color: aliceblue">
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mb-4">
                @csrf

                <div class="logo-back text-center me-2 mb-2">
                    <img  style="width: 50px; height: 50px;" src="{{ URL::asset('/img/b.png') }}">
                </div>

                <h2 class="text-center">Sign In</h2>

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')"
                        required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-control" type="password" name="password" required
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('Log in') }}</button>
                </div>
            </form>

            <div class="col-12 text-center">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
            @endif

            </div>

        </div>
    </div>
</div>
</x-guest-layout>
@include('layouts.partials.footer')
