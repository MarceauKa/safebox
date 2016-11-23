<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name'     => 'marceauka',
            'email'    => 'admin@safebox.com',
            'password' => bcrypt('password'),
            'api_token' => str_random(60),
        ]);
    }
}
