<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
      //administrador
      $rol_admin = Role::create(['name' => 'admin']);

    	//usuario
    	$rol_user = Role::create(['name' => 'user']);


      // Users permissions

      /*--- Create users----*/
      $permission = Permission::create(['name' => 'create_users']);

      $rol_admin->givePermissionTo($permission);

      /*--- Edit users----*/
      $permission = Permission::create(['name' => 'edit_users']);

      $rol_admin->givePermissionTo($permission);

      /*--- Trash users----*/
      $permission = Permission::create(['name' => 'trash_users']);

      $rol_admin->givePermissionTo($permission);


      // Posts permissions

      /*--- Create posts----*/
      $permission = Permission::create(['name' => 'create_posts']);

      $rol_admin->givePermissionTo($permission);
      $rol_user->givePermissionTo($permission);

      /*--- Edit posts----*/
      $permission = Permission::create(['name' => 'edit_posts']);

      $rol_admin->givePermissionTo($permission);
      $rol_user->givePermissionTo($permission);

      /*--- Trash posts----*/
      $permission = Permission::create(['name' => 'trash_posts']);

      $rol_admin->givePermissionTo($permission);
      $rol_user->givePermissionTo($permission);

      // Comments permissions

      /*--- Create comments----*/
      $permission = Permission::create(['name' => 'create_comments']);

      $rol_admin->givePermissionTo($permission);
      $rol_user->givePermissionTo($permission);

      /*--- Edit comments----*/
      $permission = Permission::create(['name' => 'edit_comments']);

      $rol_admin->givePermissionTo($permission);
      $rol_user->givePermissionTo($permission);

      /*--- Trash comments----*/
      $permission = Permission::create(['name' => 'trash_comments']);

      $rol_admin->givePermissionTo($permission);
      $rol_user->givePermissionTo($permission);

      //admin_user

      $admin_user = new User();
      $admin_user->name = 'Admin';
      $admin_user->email = 'admin@admin.com';
      $admin_user->birthdate = Carbon::parse('2000-01-01');
      $admin_user->country = "Venezuela";
      $admin_user->password = Hash::make("admin");
      $admin_user->save();

      $admin_user->assignRole('admin');

    }
}
