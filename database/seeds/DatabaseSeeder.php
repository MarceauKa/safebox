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
        
        DB::table('clients')->truncate();
        factory(\App\Models\Client::class, 30)->create();

        DB::table('sites')->truncate();
        factory(\App\Models\Site::class, 50)->create();

        Schema::enableForeignKeyConstraints();
    }
}
