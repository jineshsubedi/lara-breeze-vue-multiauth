<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\StaffType;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'staff_type' => StaffType::ADMIN,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'staff_type' => StaffType::STAFF,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@gmail.com',
            'staff_type' => StaffType::SUPERVISOR,
        ]);
    }
}
