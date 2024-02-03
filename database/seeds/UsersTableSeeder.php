<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'user_name' => 'defaultUser',
                'email' => 'default@example.com',
                'password' => Hash::make('testtest'),
                'profile' => 'hello world!',
            ],
            [
                'user_name' => 'イラストレーターさん',
                'email' => 'illustrator@example.com',
                'password' => Hash::make('testtest'),
                'profile' => 'hello world!',
            ],
            [
                'user_name' => 'Mr.programmer',
                'email' => 'programmer@example.com',
                'password' => Hash::make('testtest'),
                'profile' => 'hello world!',
            ],
            [
                'user_name' => '小さなハンドメイド作家',
                'email' => 'handmade@example.com',
                'password' => Hash::make('testtest'),
                'profile' => 'hello world!',

            ],
        ]);
    }
}
