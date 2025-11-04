<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\IndustryType;

class OrganizationFactory extends Factory
{
    protected $model = \App\Models\Organization::class;

    public function definition()
    {
        $industry = IndustryType::inRandomOrder()->first();
        return [
            'name' => $this->faker->unique()->company,
            'industry' => $industry ? $industry->type : $this->faker->companySuffix,
            'description' => $this->faker->optional()->catchPhrase,
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
