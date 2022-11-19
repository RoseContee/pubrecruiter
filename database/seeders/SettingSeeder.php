<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();

        Setting::create([
            'key' => 'site_name',
            'value' => 'Pub Recruiter',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'site_url',
            'value' => 'https://extension.pubrecruiter.com/',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'site_logo',
            'value' => 'assets/images/logo.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'favicon',
            'value' => 'assets/images/favicon.png',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'contact_email',
            'value' => 'Update@PubRecruiter.com',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'partnership_email',
            'value' => 'Partnerships@PubRecruiter.com',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'extension_link',
            'value' => 'https://chrome.google.com/webstore/detail/pub-recruiter/chfobgdkgknlemijfomlmoicedemnhbk',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        Setting::create([
            'key' => 'stripe_link',
            'value' => 'https://buy.stripe.com/5kAcNN9Do88hctGfYY',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
