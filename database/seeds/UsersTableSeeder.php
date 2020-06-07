<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
        User::create([
            'name'    => 'Nikhil Athawale',
            'email'    => 'nikhilathawale21@gmail.com',
            'password'   =>  Hash::make('password'),
            'remember_token' =>  rand(100,200)
        ]);
    }
}
