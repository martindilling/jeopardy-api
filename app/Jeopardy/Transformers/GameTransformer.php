<?php namespace Jeopardy\Transformers;

use Game;
use Log;
use League\Fractal\TransformerAbstract;

class GameTransformer extends TransformerAbstract
{
	/**
	 * List of resources possible to embed via this processor
	 *
	 * @var array
	 */
	protected $availableEmbeds = array(
		'user',
		'difficulties',
		'categories',
	);

	/**
	 * Turn this item object into a generic array
	 *
	 * @return array
	 */
	public function transform(Game $game)
	{
		return array(
			'id'          => (int) $game->id,
			'user_id'     => (int) $game->user_id,
			'active'      => (boolean) $game->active,
			'name'        => $game->name,
			'answer_time' => (int) $game->answer_time,
			'created_at'  => (string) $game->created_at,
			'updated_at'  => (string) $game->updated_at,
		);
	}

	/**
	 * Embed User
	 *
	 * @return League\Fractal\Resource\Item
	 */
	public function embedUser(Game $game)
	{
		$user = $game->user;

		Log::info("Embedding user-{$user->id} into game-{$game->id}");

		return $this->item($user, new UserTransformer);
	}

	/**
	 * Embed Difficulties
	 *
	 * @return League\Fractal\Resource\Item
	 */
	public function embedDifficulties(Game $game)
	{
		$difficulties = $game->difficulties;

		Log::info("Embedding difficulties into game-{$game->id}");

		return $this->collection($difficulties, new DifficultyTransformer);
	}

	/**
	 * Embed Categories
	 *
	 * @return League\Fractal\Resource\Item
	 */
	public function embedCategories(Game $game)
	{
		$categories = $game->categories;

		Log::info("Embedding categories into game-{$game->id}");

		return $this->collection($categories, new CategoryTransformer);
	}

}
