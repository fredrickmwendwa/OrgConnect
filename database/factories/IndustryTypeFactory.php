<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IndustryTypeFactory extends Factory
{
    protected $model = \App\Models\IndustryType::class;

    public function definition()
    {
        $industries = ['Technology','Finance','Healthcare','Agriculture','Manufacturing','Education','Retail','Government','Telecom','Energy'];
        return [
            'type' => $this->faker->unique()->randomElement($industries),
            'description' => $this->faker->sentence(),
            'is_active' => true,
        ];
    }
}
