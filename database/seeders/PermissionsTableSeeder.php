<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;
use Faker\Factory;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    private $providerPassword = 'secret12';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit services']);
        Permission::create(['name' => 'delete services']);
        Permission::create(['name' => 'create services']);
        
        Permission::create(['name' => 'create comments']);


        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'super-admin']);
        
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        $role2 = Role::create(['name' => 'клиент']);
        $role2->givePermissionTo('create comments');
        

        $role3 = Role::create(['name' => 'продавец']);
        $role3->givePermissionTo('create services');
        $role3->givePermissionTo('edit services');
        $role3->givePermissionTo('delete services');

        $password = Hash::make($this->providerPassword);
        // create demo users
        $user = User::factory()->create([
            'name' => 'Ivan',
            'email' => 'r6917-web@yahoo.com',
            'password' => $password,
            'email_verified_at' => now()
        ]);
        
        $user->assignRole($role1);

        for($i=1; $i < 51; $i++){
            $name = $faker->unique()->firstName();
            $user = User::factory()->create([
                'name' => $name,
                'email' => strtolower($name) . '@gmail.com',
                'password' => $password,
                'email_verified_at' => now()
            ]);

            rand(0, 1) ? $user->assignRole($role2) : $user->assignRole($role3);
            
        }
    }
}
