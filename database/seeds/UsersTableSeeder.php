<?php

use Illuminate\Database\Seeder;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset the users table
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        // generate 3 users/author
        $faker = Factory::create();

        DB::table('users')->insert([
            [
                'name' => "Masud Rana",
                'slug' => 'masud-rana',
                'email' => "user@test.com",
                'password' => bcrypt('password'),
                'bio' => $faker->text(rand(250, 300))
            ],
            [
                'name' => "Jane Doe",
                'slug' => 'jane-doe',
                'email' => "janedoe@test.com",
                'password' => bcrypt('password'),
                'bio' => $faker->text(rand(250, 300))
            ],
            [
                'name' => "Edo Masaru",
                'slug' => 'edo-masaru',
                'email' => "edo@test.com",
                'password' => bcrypt('password'),
                'bio' => $faker->text(rand(250, 300))
            ],
        ]);
    }
}
