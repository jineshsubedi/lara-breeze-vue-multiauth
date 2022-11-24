<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Department::create([
            'branch_id' => 1,
            'title' => 'Head Department',
            'minimum_leave' => 5,
            'maximum_leave' => 5,
            'department_head' => 1,
        ]);
    }
}
