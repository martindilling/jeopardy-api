<?php

class GamesTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (User::all() as $user) {
            if (rand(0, 1) == 1 || $user->id == 1) {
                for ($i = 0; $i < rand(0, 2); $i++) {
                    $games = Game::create(array(
                        'user_id'     => $user->id,
                        'active'      => $i === 0 ? true : rand(0, 1),
                        'name'        => $faker->sentence(3),
                        'answer_time' => rand(3, 12) * 10,
                    ));
                }
            }
        }
    }
}
