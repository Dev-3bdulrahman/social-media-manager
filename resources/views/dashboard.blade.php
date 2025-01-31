@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ __('Welcome back,') }} {{ $user->name }}!</h4>
                            <p class="text-muted mb-0">
                                {{ __('Your current package:') }} 
                                <strong>{{ $user->package->name }}</strong>
                            </p>
                        </div>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary">
                            {{ __('Create New Post') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Total Posts') }}</h6>
                    <h2 class="mb-0">{{ $stats['total_posts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Pending Posts') }}</h6>
                    <h2 class="mb-0">{{ $stats['pending_posts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Published Posts') }}</h6>
                    <h2 class="mb-0">{{ $stats['published_posts'] }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">{{ __('Connected Accounts') }}</h6>
                    <h2 class="mb-0">{{ $stats['connected_accounts'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Recent Posts') }}</h5>
                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-primary">
                        {{ __('View All') }}
                    </a>
                </div>
                <div class="card-body">
                    @if($recentPosts->isEmpty())
                        <p class="text-center text-muted my-4">
                            {{ __('No posts yet. Start by creating your first post!') }}
                        </p>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('Content') }}</th>
                                        <th>{{ __('Platforms') }}</th>
                                        <th>{{ __('Schedule') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPosts as $post)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($post->media->isNotEmpty())
                                                        <div class="me-2" style="width: 40px; height: 40px;">
                                                            @if($post->media->first()->type === 'image')
                                                                <img src="{{ Storage::url($post->media->first()->path) }}" 
                                                                    class="img-fluid rounded" alt="Post media">
                                                            @else
                                                                <i class="bi bi-file-play fs-2"></i>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <div class="text-truncate" style="max-width: 300px;">
                                                        {{ $post->content }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @foreach($post->platforms as $platform)
                                                    <span class="badge bg-secondary me-1">
                                                        {{ ucfirst($platform) }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{ $post->scheduled_at->format('M d, Y H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $post->status === 'pending' ? 'warning' : ($post->status === 'published' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection