<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'SuperAdmin']);
        Role::create(['name' => 'LeaveManager']);
        Role::create(['name' => 'HrHandler']);
        Role::create(['name' => 'AttendanceHandler']);
        Role::create(['name' => 'PayrollHandler']);
        Role::create(['name' => 'EventHandler']);
        Role::create(['name' => 'SurveyHandler']);

        $admin = User::where('email', 'admin@gmail.com')->first();
        $admin->assignRole(['SuperAdmin', 'LeaveManager', 'HrHandler']);
    }
}
