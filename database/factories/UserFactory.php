<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
   
    protected static ?string $password;

   
    public function definition(): array
    {   
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $faker->addProvider(new \Mmo\Faker\LoremSpaceProvider($faker));
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));

        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'role' => 'ROLE_USER',
            'description' =>  fake()->text(),
            'image' => 'users/' . $faker->image('public/storage/users', 480, 480, ['people'], false),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
