<?php

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        for ($i = 0; $i < 25; $i++) {
            $user             = new User;
            $user->email      = $i === 0 ? 'martindilling@gmail.com' : $faker->email;
            $user->password   = Hash::make('password');
            $user->name       = $i === 0 ? 'Martin Dilling-Hansen' : $faker->name;
            $user->created_at = $faker->dateTimeBetween('-40 months', 'now');
            $user->save();
        }
    }
}
