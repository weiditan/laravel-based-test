<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\User\Entities\Address;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            "address" => fake()->address,
            "zipcode" => fake()->postcode,
            "city" => fake()->city,
            "state" => fake()->state,
            "country" => fake()->country,
        ];
    }
}
