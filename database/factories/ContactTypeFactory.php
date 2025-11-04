<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactTypeFactory extends Factory
{
    protected $model = \App\Models\ContactType::class;

    public function definition()
    {
        $types = ['Email','Phone','LinkedIn','Fax','Website'];
        return [
            'type' => $this->faker->unique()->randomElement($types),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}
