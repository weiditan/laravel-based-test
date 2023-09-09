<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\AddressType;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::query()->create([
            "email" => "support@email.com",
            "password" => Hash::make("Abc123456"),
            "first_name" => "My",
            "last_name" => "Support",
            "birthdate" => "2023-01-01",
        ]);

        AddressType::query()->create(["name" => "Residential Address", "is_active" => true]);
        AddressType::query()->create(["name" => "Correspondence Address", "is_active" => true]);
    }
}
