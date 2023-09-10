<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\User\Entities\Address;
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
        AddressType::query()->create(["name" => "Residential Address", "is_active" => true]);
        AddressType::query()->create(["name" => "Correspondence Address", "is_active" => true]);

        $user = User::query()->create([
            "email" => "support@email.com",
            "password" => Hash::make("Abc123456"),
            "first_name" => "My",
            "last_name" => "Support",
            "birthdate" => "2023-01-01",
        ]);

        $user->setStatus("approved");

        $address_type_list = AddressType::query()
            ->where("is_active", "=", true)
            ->get();

        if ($address_type_list->isNotEmpty()) {
            foreach ($address_type_list as $address_type) {
                Address::factory()->create([
                    "user_id" => $user->id,
                    "address_type_id" => $address_type->id,
                ]);
            }
        }

        User::factory()
            ->count(25)
            ->create();
    }
}
