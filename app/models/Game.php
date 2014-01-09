<?php

class Game extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'games';

	/**
	 * Validation rules.
	 *
	 * @var array
	 */
	public static $rules = array();




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
		return $this->hasMany('Category');
	}

	/**
	 * Relationship: Difficulties
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function difficulties()
	{
		return $this->hasMany('Difficulty');
	}

}
