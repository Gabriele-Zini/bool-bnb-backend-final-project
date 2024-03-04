<section>
    <header>
        <h2 class="h4 font-medium ms_font-color ">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm ms_font-color">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="name" class="form-label ms_font-color ">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-label ms_font-color">{{ __('Lastname') }}</label>
            <input id="lastname" name="lastname" type="text" class="form-control"
                value="{{ old('lastname', $user->lastname) }}" required autofocus autocomplete="lastname">
            @error('lastname')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3">
            <label for="email" class="form-label ms_font-color ">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control"
                value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-muted mt-2">
                        {{ __('Your email address is unverified.') }}
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('send-verification').submit();"
                            class="text-primary">{{ __('Click here to re-send the verification email.') }}</a>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-muted">
                    {{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
