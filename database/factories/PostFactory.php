<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostFactory extends Factory
{
    public function definition(): array
    {   
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \Mmo\Faker\PicsumProvider($faker));
        $faker->addProvider(new \Mmo\Faker\LoremSpaceProvider($faker));
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));

        $title = fake()->unique()->realText(rand(10, 50));

        return [
            'user_id' =>  User::all()->random()->id,
            'category_id' => Category::all()->random()->id,
            'title' =>  $title,
            'slug' => Str::slug($title),
            'content' =>  fake()->realText(500),
            'image' => 'posts/' . $faker->image('public/storage/images', 640, 480, ['technology'], false)
        ];
    }
}
