<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IndustryType;
use App\Models\ContactType;
use App\Models\Organization;
use App\Models\Contact;
use App\Models\Address;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create industry types and contact types
        IndustryType::factory()->count(10)->create();
        ContactType::factory()->count(5)->create();

        // Create 1000 organizations
        Organization::factory()->count(1000)->create();

        // For each organization, create 1-4 contacts and 0-2 addresses
        Organization::all()->each(function ($org) {
            Contact::factory()->count(rand(1,4))->create([
                'organization_id' => $org->id,
            ]);
            if (rand(0,1)) {
                Address::factory()->count(rand(1,2))->create([
                    'organization_id' => $org->id,
                ]);
            }
        });
    }
}
