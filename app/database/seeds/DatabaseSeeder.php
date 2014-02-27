<?php

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment() === 'production') {
            $this->command->error('STOP!!!');
            $this->command->error('You are about to seed your production database!');
            if (!$this->command->confirm('Continue? [yes|no]')) {
                $this->command->info('Exiting!');
                exit();
            }
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
        $this->command->info('User table seeded!');

        $this->call('GamesTableSeeder');
        $this->command->info('Games table seeded!');

        $this->call('CategoriesTableSeeder');
        $this->command->info('Categories table seeded!');

        $this->call('DifficultiesTableSeeder');
        $this->command->info('Difficulties table seeded!');

        $this->call('QuestionsTableSeeder');
        $this->command->info('Questions table seeded!');
    }
}
