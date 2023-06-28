<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Jobs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Applicant::create([
            'jobs_id' => Jobs::inRandomOrder()->first()->id,
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->name(),
            'last_name' => fake()->lastName(),
            'email' => fake()->email(),
            'citizenship' => rand(10000,100000),
            'gender'=> fake()->randomElement(['Male', 'Female']),
            'marital_status'=> fake()->randomElement(['Married', 'Un    Married']),
            'mobile' => fake()->phoneNumber(),
            'apply_date' => fake()->dateTimeBetween('-1 year', '+1 year')->format('Y-m-d'),
            'tracking_code' => fake()->unique()->randomNumber(8, true)
        ]);
    }
}
