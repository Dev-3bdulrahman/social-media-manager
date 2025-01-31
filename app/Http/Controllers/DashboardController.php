<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $stats = [
            'total_posts' => $user->scheduledPosts()->count(),
            'pending_posts' => $user->scheduledPosts()->where('status', 'pending')->count(),
            'published_posts' => $user->scheduledPosts()->where('status', 'published')->count(),
            'failed_posts' => $user->scheduledPosts()->where('status', 'failed')->count(),
            'connected_accounts' => $user->socialAccounts()->count(),
        ];

        $recentPosts = $user->scheduledPosts()
            ->with('media')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentPosts', 'user'));
    }
}