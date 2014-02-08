<?php
namespace Jeopardy\Transformers;

use League\Fractal\TransformerAbstract;
use Log;
use Question;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * List of resources possible to embed via this processor
     *
     * @var array
     */
    protected $availableEmbeds = array(
        'category',
        'difficulty',
    );

    /**
     * Turn this item object into a generic array
     *
     * @param \Question $question
     * @return array
     */
    public function transform(Question $question)
    {
        return array(
            'id'            => (int) $question->id,
            'category_id'   => (int) $question->category_id,
            'difficulty_id' => (int) $question->difficulty_id,
            'question'      => $question->question,
            'question'      => $question->question,
            'answer'        => $question->answer,
            'created_at'    => (string) $question->created_at,
            'updated_at'    => (string) $question->updated_at,
        );
    }

    /**
     * Embed Category
     *
     * @param \Question $question
     * @return \League\Fractal\Resource\Item
     */
    public function embedCategory(Question $question)
    {
        $category = $question->category;

        Log::info("Embedding category-{$category->id} into question-{$question->id}");

        return $this->item($category, new CategoryTransformer);
    }

    /**
     * Embed Difficulty
     *
     * @param \Question $question
     * @return \League\Fractal\Resource\Item
     */
    public function embedDifficulty(Question $question)
    {
        $difficulty = $question->difficulty;

        Log::info("Embedding difficulty-{$difficulty->id} into question-{$question->id}");

        return $this->item($difficulty, new DifficultyTransformer);
    }
}
