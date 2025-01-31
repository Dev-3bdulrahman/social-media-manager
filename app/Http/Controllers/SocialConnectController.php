<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialConnectController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $package = $user->package;
        $socialAccounts = $user->socialAccounts;
        
        $platforms = [
            'facebook' => [
                'name' => 'Facebook',
                'icon' => 'facebook',
                'connected' => $socialAccounts->where('provider', 'facebook')->isNotEmpty(),
            ],
            'twitter' => [
                'name' => 'Twitter',
                'icon' => 'twitter',
                'connected' => $socialAccounts->where('provider', 'twitter')->isNotEmpty(),
            ],
            'instagram' => [
                'name' => 'Instagram',
                'icon' => 'instagram',
                'connected' => $socialAccounts->where('provider', 'instagram')->isNotEmpty(),
            ],
            'snapchat' => [
                'name' => 'Snapchat',
                'icon' => 'snapchat',
                'connected' => $socialAccounts->where('provider', 'snapchat')->isNotEmpty(),
            ],
        ];

        return view('social.connect', compact('platforms', 'package', 'socialAccounts'));
    }
}