<?php

namespace App\Http\Controllers;

use App\Models\ScheduledPost;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ScheduledPostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->scheduledPosts()
            ->with('media')
            ->orderBy('scheduled_at')
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $socialAccounts = auth()->user()->socialAccounts;
        return view('posts.create', compact('socialAccounts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'scheduled_at' => 'required|date|after:now',
            'platforms' => 'required|array',
            'platforms.*' => 'string|in:facebook,twitter,instagram,snapchat',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4|max:10240',
            'is_smart_post' => 'boolean',
            'logo' => 'required_if:is_smart_post,true|image',
        ]);

        $post = auth()->user()->scheduledPosts()->create([
            'content' => $validated['content'],
            'scheduled_at' => $validated['scheduled_at'],
            'platforms' => $validated['platforms'],
            'is_smart_post' => $request->boolean('is_smart_post'),
        ]);

        if ($request->boolean('is_smart_post') && $request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('logos', 'public');
            
            // Create smart post image
            $img = Image::make($logo);
            $img->opacity(50);
            
            // Add text
            $img->text($validated['content'], $img->width() / 2, $img->height() / 2, function($font) {
                $font->file(public_path('fonts/OpenSans-Bold.ttf'));
                $font->size(24);
                $font->color('#000000');
                $font->align('center');
                $font->valign('middle');
            });

            $smartPostPath = 'smart-posts/' . uniqid() . '.jpg';
            $img->save(storage_path('app/public/' . $smartPostPath));

            $post->update(['logo_path' => $logoPath]);
            $post->media()->create([
                'type' => 'image',
                'path' => $smartPostPath,
            ]);
        }

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('posts', 'public');
                $type = str_starts_with($file->getMimeType(), 'video/') ? 'video' : 'image';
                
                $post->media()->create([
                    'type' => $type,
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post scheduled successfully.');
    }
}