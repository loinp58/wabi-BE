<?php

use App\Models\Store;
use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 3; $i++) {
            Store::create([
                'name' => $faker->name()
            ]);
        }
    }
}
