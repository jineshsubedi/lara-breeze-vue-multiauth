<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Enums\StatusEnum;
use App\Models\SettingEmail;
use App\Models\SettingSocial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'name' => env('APP_NAME'),
            'email' => 'jinesh1094@gmail.com',
            'status' => StatusEnum::ACTIVE
        ]);
        SettingEmail::create([
            'setting_id' => $setting->id,
            'protocal' => 'SMTP',
            'parameter' => 'noreply@jinesh.com',
            'host_name' => 'smtp.mailtrap.io',
            'username' => 'apple',
            'password' => 'password',
            'smtp_port' => '2525',
            'encryption' => 'tls',
        ]);
        SettingSocial::create([
            'setting_id' => $setting->id,
            'name' => 'Facebook',
            'icon' => 'fab fa-facebook',
            'url' => 'Facebook.com',
        ]);
    }
}
