<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\TaskCategory;
use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Admin',
                'email' => 'admin@earnethio.com',
                'password' => Hash::make('Haile@1221'),
            ]
        );

        GeneralSetting::firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'EarnEthio',
                'cur_text' => 'ETB',
                'cur_sym' => 'Br',
                'base_color' => '#10b981',
                'secondary_color' => '#3b82f6',
                'min_withdraw' => 50,
                'activation_fee' => 250,
                'daily_claim_reward' => 1,
            ]
        );

        Language::firstOrCreate(
            ['code' => 'en'],
            [
                'name' => 'English',
                'is_default' => 1,
            ]
        );

        Page::firstOrCreate(
            ['slug' => '/'],
            [
                'name' => 'Home',
                'status' => 1,
            ]
        );

        $categories = [
            ['name' => 'Social Media Engagement', 'slug' => 'social-media', 'icon' => 'fab fa-facebook'],
            ['name' => 'Micro Tasks', 'slug' => 'micro-tasks', 'icon' => 'fas fa-tasks'],
            ['name' => 'Surveys', 'slug' => 'surveys', 'icon' => 'fas fa-poll'],
            ['name' => 'Freelance Gigs', 'slug' => 'freelance', 'icon' => 'fas fa-laptop-code'],
            ['name' => 'Daily Claim', 'slug' => 'daily-claim', 'icon' => 'fas fa-calendar-day'],
        ];

        foreach ($categories as $cat) {
            TaskCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $this->call(TaskSeeder::class);
    }
}
