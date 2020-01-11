<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'name'			=>	'Loriana Machado',
        	'email'			=>	'loriana@gmail.com',
        	'password'	=>	bcrypt('loriana'),
        ]);
    }
}
