<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
    	"title" => $faker->sentence(3),
		"content" => $faker->text(30),
		"date" => \Faker\Provider\DateTime::dateTime('now'),
		"user_id" => function () {
            return User::inRandomOrder()->first()->id;
        }
    ];
});


