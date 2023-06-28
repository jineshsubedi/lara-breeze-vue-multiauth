<?php

namespace Database\Factories;

use App\Models\District;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'description' => fake()->text(),
            'province_id' => Province::factory()->create()->id,
            'district_id' => District::factory()->create()->id,
            'is_head' => 1
        ];
    }
}
