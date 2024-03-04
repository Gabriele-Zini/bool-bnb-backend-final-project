@include('layouts.navigation')
<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-10 col-md-8 col-lg-6 ms_bg-card p-4 rounded " style="background-color: aliceblue">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="logo-back text-center me-2 mb-2">
                        <img  style="width: 50px; height: 50px;" src="{{ URL::asset('/img/b.png') }}">
                    </div>
            
                    <h2 class="text-center">Sign Up</h2>

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Name') }}</label>
                        <input id="name" class="form-control" type="text" name="name"
                            value="{{ old('name') }}" required autofocus autocomplete="name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Lastname -->
                    <div class="mb-3">
                        <label for="lastname" class="form-label">{{ __('Lastname') }}</label>
                        <input id="lastname" class="form-control" type="text" name="lastname"
                            value="{{ old('lastname') }}" required autofocus autocomplete="lastname">
                        <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" class="form-control" type="email" name="email"
                            value="{{ old('email') }}" required autocomplete="username">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" class="form-control" type="password" name="password" required
                            autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('login') }}" class="text-decoration-none">{{ __('Already registered?') }}</a>
                        <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
    h4 {
        color: #98A2B3;
    }
    .ms_font-color {
        color: #98A2B3;
    }
    </style>
</x-guest-layout>
@include('layouts.partials.footer')
