<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Models\Country;

class UsersTest extends TestCase
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

        // Create user
        $user = factory(User::class)->create();
        $this->assertDatabaseHas('users', ['id'=>$user->id]);

        // Read user
        $response = $this->actingAs($admin)->get('/admin/users/get');
        $response->assertStatus(200);

        // Update user
        $response = $this->actingAs($admin)->post('/admin/users/edit', ['_token'=>csrf_token(), 'user_id'=>1, 'name'=>'Admin modificado', 'birthdate'=>date('Y-m-d'), 'country'=>Country::inRandomOrder()->first()->name, 'email'=>'admin@admin.com']);
        $response->assertStatus(302);

        // Delete user
        $response=$this->actingAs($admin)->get('/admin/users/trash/'.$user->id);
        $response->assertStatus(302);
    }
}
