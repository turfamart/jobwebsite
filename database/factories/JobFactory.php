<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'user_id' => 1,
            'job_type_id' => rand(1,5),
            'category_id' => rand(1,5),
            'vacancy' => rand(1,5),
            'location' => fake()->city,
            'description' => fake()->text,
            'user_id' => rand(1,3),
            'company_name' => fake()->name,
             'benefits' => fake()->text,
             'responsibility' => fake()->text,
             'qualifications' => fake()->text,
             'keywords' => fake()->text,
             'company_location' => fake()->name,
             'company_website' => fake()->name,
         
        ];
    }
}
