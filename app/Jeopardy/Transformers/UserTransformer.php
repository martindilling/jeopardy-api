<?php namespace Jeopardy\Transformers;

use User;
use Log;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
	protected $availableEmbeds = array(
		'games',
	);

	/**
	 * Turn this item object into a generic array
	 *
	 * @return array
	 */
	public function transform(User $user)
	{
		return array(
			'id'         => (int) $user->id,
			'email'      => $user->email,
			'password'   => $user->password,
			'name'       => $user->name,
			'created_at' => (string) $user->created_at,
		);
	}

	/**
	 * Embed Games
	 *
	 * @return League\Fractal\Resource\Item
	 */
	public function embedGames(User $user)
	{
		$games = $user->games;

		Log::info("Embedding games into user-{$user->id}");

		return $this->collection($games, new GameTransformer);
	}

}
