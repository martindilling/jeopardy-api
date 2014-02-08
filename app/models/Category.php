<?php

/**
 * An Eloquent Model: 'Category'
 *
 * @property integer                                                   $id
 * @property integer                                                   $game_id
 * @property boolean                                                   $active
 * @property integer                                                   $order
 * @property string                                                    $name
 * @property \Carbon\Carbon                                            $created_at
 * @property \Carbon\Carbon                                            $updated_at
 * @property-read \Game                                                $game
 * @property-read \Illuminate\Database\Eloquent\Collection|\Question[] $questions
 */
class Category extends Eloquent
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
    protected $table = 'categories';

    /**
     * Relationship: Game
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function game()
    {
        return $this->belongsTo('Game');
    }

    /**
     * Relationship: Questions
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany('Question');
    }
}
