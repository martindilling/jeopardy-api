<?php namespace Jeopardy\Transformers;

use Category;
use Log;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
	/**
	 * List of resources possible to embed via this processor
	 *
	 * @var array
	 */
	protected $availableEmbeds = array(
		'game',
		'questions',
	);

	/**
	 * Turn this item object into a generic array
	 *
	 * @return array
	 */
	public function transform(Category $category)
	{
		return array(
			'id'          => (int) $category->id,
			'game_id'     => (int) $category->game_id,
			'active'      => (boolean) $category->active,
			'order'       => (int) $category->order,
			'name'        => $category->name,
			'created_at'  => (string) $category->created_at,
			'updated_at' => (string) $category->updated_at,
		);
	}

	/**
	 * Embed Game
	 *
	 * @return League\Fractal\Resource\Item
	 */
	public function embedGame(Category $category)
	{
		$game = $category->game;

		Log::info("Embedding game-{$game->id} into category-{$category->id}");

		return $this->item($game, new GameTransformer);
	}

	/**
	 * Embed Questions
	 *
	 * @return League\Fractal\Resource\Item
	 */
	public function embedQuestions(Category $category)
	{
		$questions = $category->questions;

		Log::info("Embedding questions into category-{$category->id}");

		return $this->collection($questions, new QuestionTransformer);
	}

}
