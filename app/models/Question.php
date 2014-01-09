<?php

class Question extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'questions';

	/**
	 * Validation rules.
	 *
	 * @var array
	 */
	public static $rules = array();




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
