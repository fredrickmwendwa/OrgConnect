<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organization;
use App\Models\ContactType;

class ContactFactory extends Factory
{
    protected $model = \App\Models\Contact::class;

    public function definition()
    {
        $org = Organization::inRandomOrder()->first();
        $ctype = ContactType::inRandomOrder()->first();

        $type = $ctype ? $ctype->type : $this->faker->randomElement(['Email','Phone','LinkedIn']);
        $value = $type === 'Email' ? $this->faker->unique()->safeEmail :
                 ($type === 'Phone' ? $this->faker->phoneNumber : $this->faker->url);

        return [
            'organization_id' => $org ? $org->id : Organization::factory(),
            'contact_type' => $type,
            'contact_value' => $value,
            'description' => $this->faker->optional()->sentence,
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
