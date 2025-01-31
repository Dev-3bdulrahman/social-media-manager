<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'Basic',
                'description' => 'Perfect for individuals and small businesses getting started with social media management',
                'price' => 9.99,
                'post_limit' => 30,
                'social_account_limit' => 3,
                'smart_post_enabled' => false,
            ],
            [
                'name' => 'Professional',
                'description' => 'Ideal for growing businesses with multiple social media accounts',
                'price' => 29.99,
                'post_limit' => 100,
                'social_account_limit' => 10,
                'smart_post_enabled' => true,
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Complete solution for large businesses and agencies',
                'price' => 99.99,
                'post_limit' => -1, // Unlimited
                'social_account_limit' => -1, // Unlimited
                'smart_post_enabled' => true,
            ],
        ];

        foreach ($packages as $package) {
            Package::create($package);
        }
    }
}