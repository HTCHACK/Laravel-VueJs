<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        factory(App\Series::class,10)->create()->each(function($series){
            $series->videos()->saveMany(factory(App\Video::class,10)->make());
        });


    }
}
