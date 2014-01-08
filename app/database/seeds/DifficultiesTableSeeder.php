<?php

class DifficultiesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (Game::all() as $game) {
			for ($i = 0; $i < rand(1, 6); $i++) {

				$difficulties = Difficulty::create(array(
					'game_id'     => $game->id,
					'order'       => $i+1,
					'name'        => $faker->sentence(1),
					'points'      => ($i+1)*100,
				));
			}
		}
	}

}
