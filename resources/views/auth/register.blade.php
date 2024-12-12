
<br><br><br>
<x-guest-layout>
    <div class="container mt-4" style="max-width: 500px;">
        <div class="card shadow-sm p-4">
            <h2 class="mb-4 text-center">{{ __('Register as Vendor') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')
                        <div class="text-danger mt-2 small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
                    @error('email')
                        <div class="text-danger mt-2 small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
                    @error('password')
                        <div class="text-danger mt-2 small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger mt-2 small">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Role (hidden field to register as vendor) -->
                <input type="hidden" name="role" value="vendor">

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-4">
                    {{ __('Register as Vendor') }}
                </button>

                <!-- Already Registered Link -->
                <div class="mt-3 mb-3">
                    <a class="text-secondary" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
<br><br><br>
