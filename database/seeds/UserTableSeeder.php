<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Crypt;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('name', 'Administrator')->first();

        $admin = new User();
        $admin->name = 'Rob';
        $admin->email = 'irtehbom@gmail.com';
        $admin->password = bcrypt('Effort7891');
        $admin->save();
        $admin->roles()->attach($admin);
    }
}
