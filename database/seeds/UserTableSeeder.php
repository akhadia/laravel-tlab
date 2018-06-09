<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::insert([
            [
                'name'  => 'Akhadia Ciputra',
                'username'  => 'akhadia.ciputra',
                'email'  => 'akhadia.ciputra@gmail.com',
                'password'  => bcrypt(123456),
            ]
        ]);
    }
}
