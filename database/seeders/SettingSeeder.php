<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::create([
            'store_name' => 'Prima House',
            'store_phone' => '628123456789',
            'free_shipping_radius' => 5,
            'shipping_fee' => 5000,
            'is_active' => true
        ]);
    }
}