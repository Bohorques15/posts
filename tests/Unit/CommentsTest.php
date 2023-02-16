<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Post;
use App\Models\Comment;
use App\User;
use Faker\Factory as Faker;

class CommentsTest extends TestCase
{
	use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        // Run the DatabaseSeeder...
        $this->seed();

        //admin user
        $admin = User::where('email','admin@admin.com')->first();

        // Create comment
        $comment = factory(Comment::class)->create();
        $this->assertDatabaseHas('comments', ['id'=>$comment->id]);

        // Read post
        $response = $this->actingAs($admin)->get('/admin/comments/get');
        $response->assertStatus(200);


        //Faker for dummie data
        $faker = Faker::create();

        // Update post
        $response = $this->actingAs($admin)->post('/admin/comments/edit', ['_token'=>csrf_token(), 'comment_id'=>$comment->id, "content" => $faker->text(10)]);
        $response->assertStatus(302);

        // Delete post
        $response=$this->actingAs($admin)->get('/admin/comments/trash/'.$comment->id);
        $response->assertStatus(302);
    }
}
