<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Crypt;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role = new Role();
        $role->name = 'Administrator';
        $role->description = 'Administrator';
        $role->save();

        $role = new Role();
        $role->name = 'Consultant';
        $role->description = 'Consultant';
        $role->save();

        $role = new Role();
        $role->name = 'Customer';
        $role->description = 'Customer';
        $role->save();
    }

}
