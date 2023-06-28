<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Province;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province = [
            [
                'title' => 'Province 1'
            ],
            [
                'title' => 'Province 2'
            ],
            [
                'title' => 'Bagmati'
            ],
            [
                'title' => 'Gandaki'
            ],
            [
                'title' => 'Lumbini'
            ],
            [
                'title' => 'Karnali'
            ],
            [
                'title' => 'Sudurpashchim'
            ],
        ];
        Province::insert($province);
    }
}
