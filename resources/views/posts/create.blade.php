@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Schedule New Post') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="content" class="form-label">{{ __('Post Content') }}</label>
                            <textarea id="content" class="form-control @error('content') is-invalid @enderror" 
                                name="content" rows="4" required>{{ old('content') }}</textarea>
                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label">{{ __('Schedule Date & Time') }}</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" 
                                id="scheduled_at" name="scheduled_at" value="{{ old('scheduled_at') }}" required>
                            @error('scheduled_at')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('Platforms') }}</label>
                            <div class="d-flex gap-3">
                                @foreach(['facebook', 'twitter', 'instagram', 'snapchat'] as $platform)
                                    @if($socialAccounts->where('provider', $platform)->count() > 0)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                name="platforms[]" value="{{ $platform }}" 
                                                id="platform_{{ $platform }}"
                                                {{ in_array($platform, old('platforms', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="platform_{{ $platform }}">
                                                {{ ucfirst($platform) }}
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            @error('platforms')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="media" class="form-label">{{ __('Media Files') }}</label>
                            <input type="file" class="form-control @error('media.*') is-invalid @enderror" 
                                id="media" name="media[]" multiple accept="image/*,video/*">
                            @error('media.*')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_smart_post" 
                                    name="is_smart_post" {{ old('is_smart_post') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_smart_post">
                                    {{ __('Create Smart Post') }}
                                </label>
                            </div>
                        </div>

                        <div id="logoUpload" class="mb-3" style="display: none;">
                            <label for="logo" class="form-label">{{ __('Logo for Smart Post') }}</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Schedule Post') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('is_smart_post').addEventListener('change', function() {
    const logoUpload = document.getElementById('logoUpload');
    logoUpload.style.display = this.checked ? 'block' : 'none';
});
</script>
@endpush
@endsection