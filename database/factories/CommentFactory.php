<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
		"content" => $faker->text(10),
		"date" => \Faker\Provider\DateTime::dateTime('now'),
		"user_id" => function () {
            return User::inRandomOrder()->first()->id;
        },
		"post_id" => function () {
            return Post::inRandomOrder()->first()->id;
        }
    ];
});
