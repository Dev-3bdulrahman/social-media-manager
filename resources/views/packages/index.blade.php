@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center mb-4">{{ __('Choose Your Package') }}</h2>

            <div class="row g-4">
                @foreach($packages as $package)
                    <div class="col-md-4">
                        <div class="card h-100 {{ auth()->user()->package_id === $package->id ? 'border-primary' : '' }}">
                            <div class="card-body">
                                <h3 class="card-title">{{ $package->name }}</h3>
                                <p class="text-muted">{{ $package->description }}</p>
                                <h4 class="mb-4">${{ number_format($package->price, 2) }}<small class="text-muted">/month</small></h4>
                                
                                <ul class="list-unstyled mb-4">
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {{ $package->post_limit === -1 ? __('Unlimited posts') : __(':limit posts per month', ['limit' => $package->post_limit]) }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                                        {{ $package->social_account_limit === -1 ? __('Unlimited social accounts') : __(':limit social accounts', ['limit' => $package->social_account_limit]) }}
                                    </li>
                                    @if($package->smart_post_enabled)
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                                            {{ __('Smart Post Feature') }}
                                        </li>
                                    @endif
                                </ul>

                                @if(auth()->user()->package_id === $package->id)
                                    <button class="btn btn-primary w-100" disabled>
                                        {{ __('Current Package') }}
                                    </button>
                                @else
                                    <form action="{{ route('packages.upgrade') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="package_id" value="{{ $package->id }}">
                                        <button type="submit" class="btn btn-outline-primary w-100">
                                            {{ __('Upgrade to :name', ['name' => $package->name]) }}
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection