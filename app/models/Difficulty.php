<?php

class Difficulty extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'difficulties';

	/**
	 * Validation rules.
	 *
	 * @var array
	 */
	public static $rules = array();




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
