<?php

class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (Game::all() as $game) {
			for ($i = 0; $i < rand(3, 5); $i++) {

				$categories = Category::create(array(
					'game_id'     => $game->id,
					'active'      => $i === 0 ? true : rand(0, 1),
					'order'       => $i+1,
					'name'        => $faker->sentence(1),
				));
			}
		}
	}

}
