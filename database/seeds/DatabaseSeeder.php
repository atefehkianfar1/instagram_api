<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,10) as $index) {
            DB::table('users')->insert([
                'username' => $faker->userName,
                'name' => $faker->name,
                'website' => $faker->url,
                'bio' => $faker->text,
                'profile_photo'=>'public/image/user/user16.png',
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'active' => 1
            ]);
        }

    }
}
