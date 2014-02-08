<?php

/**
 * An Eloquent Model: 'Game'
 *
 * @property integer                                                     $id
 * @property integer                                                     $user_id
 * @property boolean                                                     $active
 * @property string                                                      $name
 * @property integer                                                     $answer_time
 * @property \Carbon\Carbon                                              $created_at
 * @property \Carbon\Carbon                                              $updated_at
 * @property-read \User                                                  $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\Category[]   $categories
 * @property-read \Illuminate\Database\Eloquent\Collection|\Difficulty[] $difficulties
 */
class Game extends Eloquent
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
    protected $table = 'games';

    /**
     * Relationship: User
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * Relationship: Categories
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories()
    {
        return $this->hasMany('Category')->orderBy('order', 'asc');
    }

    /**
     * Relationship: Difficulties
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function difficulties()
    {
        return $this->hasMany('Difficulty')->orderBy('order', 'asc');
    }
}
