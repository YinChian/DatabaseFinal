<?php

namespace Database\Factories;

use App\Models\Customers;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomersFactory extends Factory
{
    protected $model = Customers::class;

    public function definition()
    {
        return [
            'Name' => $this->faker->name,
            'Email' => $this->faker->unique()->safeEmail,
            'PhoneNumber' => $this->faker->phoneNumber,
            'Address' => $this->faker->address,
            'RegistrationDate' => $this->faker->date,
            'CustomerType' => $this->faker->randomElement(['Individual', 'Corporate']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

