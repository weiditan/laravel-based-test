<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Entities\Address;
use Modules\User\Entities\AddressType;
use Modules\User\Entities\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            "first_name" => fake()->firstName(),
            "last_name" => fake()->lastName(),
            "email" => fake()
                ->unique()
                ->safeEmail(),
            "password" => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            "birthdate" => fake()->date,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
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
        });
    }
}
