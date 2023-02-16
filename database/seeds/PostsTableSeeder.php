<?php

use Illuminate\Database\Seeder;
use App\Models\Post;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    // Create posts instances...
	    $posts = factory(Post::class, 22)->create();
    }
}
