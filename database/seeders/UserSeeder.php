<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\StaffType;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'staff_type' => StaffType::ADMIN,
            'status' => User::CURRENTLY_WORKING,
            'branch_id' => 1,
            'department_id' => 0,
            'shift_time_id' => 0,
            'designation_id' => 0,
            'supervisor_id' => 0,
        ]);
        User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'staff_type' => StaffType::STAFF,
            'status' => User::CURRENTLY_WORKING,
            'branch_id' => 1,
            'department_id' => 0,
            'shift_time_id' => 0,
            'designation_id' => 0,
            'supervisor_id' => 0,
        ]);
        User::factory()->create([
            'name' => 'Supervisor',
            'email' => 'supervisor@gmail.com',
            'staff_type' => StaffType::SUPERVISOR,
            'status' => User::CURRENTLY_WORKING,
            'branch_id' => 1,
            'department_id' => 0,
            'shift_time_id' => 0,
            'designation_id' => 0,
            'supervisor_id' => 0,
        ]);
    }
}
