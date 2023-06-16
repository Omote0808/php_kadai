<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */


class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'kana_name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'tel' => $this->faker->phoneNumber(),
            'representative' => $this->faker->name(),
            'kana_representative' => $this->faker->kanaName(),
            
        ];
    }
}
