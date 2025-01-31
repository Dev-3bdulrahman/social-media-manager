@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('Scheduled Posts') }}</h2>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            {{ __('Create New Post') }}
        </a>
    </div>

    @if($posts->isEmpty())
        <div class="alert alert-info">
            {{ __('No scheduled posts found. Create your first post!') }}
        </div>
    @else
        <div class="row">
            @foreach($posts as $post)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        @if($post->media->isNotEmpty())
                            <div class="card-img-top">
                                @foreach($post->media as $media)
                                    @if($media->type === 'image')
                                        <img src="{{ Storage::url($media->path) }}" 
                                            class="img-fluid" alt="Post media">
                                    @else
                                        <video class="w-100" controls>
                                            <source src="{{ Storage::url($media->path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <div class="card-body">
                            <p class="card-text">{{ $post->content }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    {{ __('Scheduled for:') }} 
                                    {{ $post->scheduled_at->format('M d, Y H:i') }}
                                </small>
                                <span class="badge bg-{{ $post->status === 'pending' ? 'warning' : ($post->status === 'published' ? 'success' : 'danger') }}">
                                    {{ ucfirst($post->status) }}
                                </span>
                            </div>
                            <div class="mt-2">
                                <small class="text-muted">{{ __('Platforms:') }}</small>
                                <div class="d-flex gap-2 mt-1">
                                    @foreach($post->platforms as $platform)
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($platform) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection