<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		for ($i = 0; $i < 50; $i++) {

			$user = User::create(array(
				'email'      => $i === 0 ? 'martindilling@gmail.com' : $faker->email,
				'password'   => Hash::make('password'),
				'name'       => $i === 0 ? 'Martin Dilling-Hansen' : $faker->name,
				'created_at' => $faker->dateTimeBetween('-40 months', 'now'),
			));
		}
	}

}
