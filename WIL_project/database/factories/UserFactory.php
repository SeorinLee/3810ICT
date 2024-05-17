<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition()
    {
        $userType = $this->faker->randomElement(['volunteer', 'expert', 'manager']);
        $prefix = $userType === 'volunteer' ? 'v' : ($userType === 'expert' ? 'e' : 'm');
        $userCode = $prefix . $this->faker->unique()->numberBetween(100000, 999999);

        return [
            'name' => $this->faker->name,
            'user_code' => $userCode,
            'user_type' => $userType,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ];
    }
}
