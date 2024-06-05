<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Country;
use App\Models\Service;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Country::factory(5)->create();
        User::factory(5)->create()->each(function ($user) {
            $user->companies()->saveMany(Company::factory(2)->make())->each(function ($company) {
                $company->services()->saveMany(Service::factory(2)->make());
            });
        });
    }
}
