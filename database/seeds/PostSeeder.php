<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
            foreach(range(1,10) as $in){
                DB::table('posts')->insert([
                    'caption' => $faker->text,
                    'user_id' => $in,
                    'active' => 1,
                    'created_at'=>Carbon::now()
                ]);
                foreach (range(1,3) as $i){
                    DB::table('post_files')->insert([
                        'post_id' => $in,
                        'src' => 'public/image/post/img'.$i.'.jpg',
                        'type' => 'photo'
                    ]);
                }
        }
    }
}
