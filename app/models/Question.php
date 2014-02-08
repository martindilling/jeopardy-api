<?php

/**
 * An Eloquent Model: 'Question'
 *
 * @property integer          $id
 * @property integer          $category_id
 * @property integer          $difficulty_id
 * @property string           $question
 * @property string           $answer
 * @property \Carbon\Carbon   $created_at
 * @property \Carbon\Carbon   $updated_at
 * @property-read \Category   $category
 * @property-read \Difficulty $difficulty
 */
class Question extends Eloquent
{
    /**
     * Validation rules.
     *
     * @var array
     */
    public static $rules = array();

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';

    /**
     * Relationship: Category
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Category');
    }

    /**
     * Relationship: Difficulty
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function difficulty()
    {
        return $this->belongsTo('Difficulty');
    }
}
