<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    // Create users instances...
	    $users = factory(User::class, 16)->create();

	    foreach ($users as $user) {
	    	$user->assignRole('user');
	    }
    }
}
