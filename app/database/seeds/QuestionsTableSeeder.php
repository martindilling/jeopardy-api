<?php

class QuestionsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (Category::all() as $category) {
            foreach (Difficulty::whereGameId($category->game_id)->get() as $difficulty) {
                if (rand(0, 6) != 1) {
                    $questions = Question::create(array(
                        'category_id'   => $category->id,
                        'difficulty_id' => $difficulty->id,
                        'question'      => $faker->sentence(8),
                        'answer'        => $faker->name,
                    ));
                }
            }
        }
    }
}
