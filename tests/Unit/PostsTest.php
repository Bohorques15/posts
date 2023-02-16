<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\User;
use Faker\Factory as Faker;

class PostsTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCrud()
    {
        // Run the DatabaseSeeder...
        $this->seed();

        //admin user
        $admin = User::where('email','admin@admin.com')->first();

        // Create post
        $post = factory(Post::class)->create();
        $this->assertDatabaseHas('posts', ['id'=>$post->id]);

        // Read post
        $response = $this->actingAs($admin)->get('/admin/posts/get');
        $response->assertStatus(200);


        //Faker for dummie data
        $faker = Faker::create();

        // Update post
        $response = $this->actingAs($admin)->post('/admin/posts/edit', ['_token'=>csrf_token(), 'post_id'=>$post->id, "title" => $faker->sentence(3), "content" => $faker->text(30)]);
        $response->assertStatus(302);

        // Delete post
        $response=$this->actingAs($admin)->get('/admin/posts/trash/'.$post->id);
        $response->assertStatus(302);
    }
}
