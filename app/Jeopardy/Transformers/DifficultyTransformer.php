<?php
namespace Jeopardy\Transformers;

use Difficulty;
use League\Fractal\TransformerAbstract;
use Log;

class DifficultyTransformer extends TransformerAbstract
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
     * @param \Difficulty $difficulty
     * @return array
     */
    public function transform(Difficulty $difficulty)
    {
        return array(
            'id'         => (int) $difficulty->id,
            'game_id'    => (int) $difficulty->game_id,
            'order'      => (int) $difficulty->order,
            'name'       => $difficulty->name,
            'points'     => (int) $difficulty->points,
            'created_at' => (string) $difficulty->created_at,
            'updated_at' => (string) $difficulty->updated_at,
        );
    }

    /**
     * Embed Game
     *
     * @param \Difficulty $difficulty
     * @return \League\Fractal\Resource\Item
     */
    public function embedGame(Difficulty $difficulty)
    {
        $game = $difficulty->game;

        Log::info("Embedding game-{$game->id} into difficulty-{$difficulty->id}");

        return $this->item($game, new GameTransformer);
    }

    /**
     * Embed Questions
     *
     * @param \Difficulty $difficulty
     * @return \League\Fractal\Resource\Item
     */
    public function embedQuestions(Difficulty $difficulty)
    {
        $questions = $difficulty->questions;

        Log::info("Embedding questions into difficulty-{$difficulty->id}");

        return $this->collection($questions, new QuestionTransformer);
    }
}
