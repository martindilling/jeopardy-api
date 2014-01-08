<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		if (App::environment() === 'production') {
			exit('I just stopped you getting fired. Love Phil');
		}

		Eloquent::unguard();

		$tables = array(
			'users',
			'games',
			'categories',
			'difficulties',
			'questions',
		);

		foreach ($tables as $table) {
			DB::table($table)->truncate();
		}

		$this->call('UsersTableSeeder');
		$this->call('GamesTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('DifficultiesTableSeeder');
		$this->call('QuestionsTableSeeder');
	}

}
