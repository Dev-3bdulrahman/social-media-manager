@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm" class="form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" 
                                name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">{{ __('Select Package') }}</label>
                            <div class="row g-3">
                                @foreach($packages as $package)
                                    <div class="col-md-6">
                                        <div class="card h-100 {{ old('package_id') == $package->id ? 'border-primary' : '' }}">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="package_id" 
                                                        id="package_{{ $package->id }}" value="{{ $package->id }}"
                                                        {{ old('package_id') == $package->id ? 'checked' : '' }} required>
                                                    <label class="form-check-label" for="package_{{ $package->id }}">
                                                        <h5 class="mb-1">{{ $package->name }}</h5>
                                                        <p class="text-muted mb-2">{{ $package->description }}</p>
                                                        <h4 class="mb-2">${{ number_format($package->price, 2) }}/month</h4>
                                                        <ul class="list-unstyled">
                                                            <li>
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                {{ $package->post_limit === -1 ? 'Unlimited' : $package->post_limit }} posts
                                                            </li>
                                                            <li>
                                                                <i class="bi bi-check-circle-fill text-success"></i>
                                                                {{ $package->social_account_limit === -1 ? 'Unlimited' : $package->social_account_limit }} social accounts
                                                            </li>
                                                            @if($package->smart_post_enabled)
                                                                <li>
                                                                    <i class="bi bi-check-circle-fill text-success"></i>
                                                                    Smart Post Feature
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('package_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection