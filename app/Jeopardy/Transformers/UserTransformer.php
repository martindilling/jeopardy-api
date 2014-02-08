<?php
namespace Jeopardy\Transformers;

use League\Fractal\TransformerAbstract;
use Log;
use User;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableEmbeds = array(
        'games',
    );

    /**
     * Turn this item object into a generic array
     *
     * @param \User $user
     * @return array
     */
    public function transform(User $user)
    {
        return array(
            'id'         => (int) $user->id,
            'email'      => $user->email,
            // 'password'   => $user->password,
            'name'       => $user->name,
            'created_at' => (string) $user->created_at,
            'updated_at' => (string) $user->updated_at,
        );
    }

    /**
     * Embed Games
     *
     * @param \User $user
     * @return \League\Fractal\Resource\Item
     */
    public function embedGames(User $user)
    {
        $games = $user->games;

        Log::info("Embedding games into user-{$user->id}");

        return $this->collection($games, new GameTransformer);
    }
}
