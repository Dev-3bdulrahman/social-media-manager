@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Connect Social Media Accounts') }}</h4>
                </div>

                <div class="card-body">
                    <div class="alert alert-info">
                        <h5 class="alert-heading">{{ __('Your Package:') }} {{ $package->name }}</h5>
                        <p class="mb-0">
                            {{ __('You can connect up to') }} 
                            {{ $package->social_account_limit === -1 ? __('unlimited') : $package->social_account_limit }}
                            {{ __('social media accounts') }}
                        </p>
                    </div>

                    @if($socialAccounts->count() >= $package->social_account_limit && $package->social_account_limit !== -1)
                        <div class="alert alert-warning">
                            {{ __('You have reached your social account limit. Upgrade your package to add more accounts.') }}
                            <a href="{{ route('packages.index') }}" class="alert-link">{{ __('View Packages') }}</a>
                        </div>
                    @endif

                    <div class="row g-4">
                        @foreach($platforms as $provider => $platform)
                            <div class="col-md-6">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <i class="bi bi-{{ $platform['icon'] }} fs-4 me-2"></i>
                                            <h5 class="mb-0">{{ $platform['name'] }}</h5>
                                        </div>

                                        @if($platform['connected'])
                                            <div class="d-flex align-items-center text-success">
                                                <i class="bi bi-check-circle-fill me-2"></i>
                                                <span>{{ __('Connected') }}</span>
                                            </div>
                                        @else
                                            @if($socialAccounts->count() < $package->social_account_limit || $package->social_account_limit === -1)
                                                <a href="{{ route('social.redirect', $provider) }}" 
                                                    class="btn btn-outline-primary">
                                                    {{ __('Connect') }} {{ $platform['name'] }}
                                                </a>
                                            @else
                                                <button class="btn btn-outline-secondary" disabled>
                                                    {{ __('Upgrade to Connect') }}
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($socialAccounts->isNotEmpty())
                        <div class="mt-4">
                            <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                {{ __('Start Creating Posts') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection