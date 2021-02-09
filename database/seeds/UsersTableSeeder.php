<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_user = User::create([
            'name' => 'Ahmed Lord',
            'email' => 'super_admin@gmail.com',
            'password' => bcrypt(123456789)
        ]);

        $first_user->attachRole('super_admin');
    }
}
