<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::create([
            'name' => 'Head Office',
            'email' => 'noreply@headoffice.com',
            'description' => 'this is Head Office',
            'province_id' => 1,
            'district_id' => 1,
            'is_head' => 1
        ]);
    }
}
