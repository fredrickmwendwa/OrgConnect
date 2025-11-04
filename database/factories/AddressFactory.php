<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organization;

class AddressFactory extends Factory
{
    protected $model = \App\Models\Address::class;

    public function definition()
    {
        return [
            'organization_id' => Organization::inRandomOrder()->first() ? Organization::inRandomOrder()->first()->id : Organization::factory(),
            'building_name' => $this->faker->buildingNumber . ' ' . $this->faker->streetName,
            'street_name' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
