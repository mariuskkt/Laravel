<?php

use Illuminate\Database\Seeder;

class AchievementTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Achievement::class,10)->create();
    }
}
