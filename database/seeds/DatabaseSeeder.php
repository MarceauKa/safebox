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
    	Schema::disableForeignKeyConstraints();

        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name'     => 'admin',
            'email'    => 'admin@safebox.com',
            'password' => bcrypt('password'),
            'api_token' => str_random(60),
        ]);

        DB::table('clients')->truncate();
        factory(\App\Models\Client::class, 30)->create();

        DB::table('sites')->truncate();
        factory(\App\Models\Site::class, 50)->create();

        Schema::enableForeignKeyConstraints();
    }
}
