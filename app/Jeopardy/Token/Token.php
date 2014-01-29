<?php namespace Jeopardy\Token;

use Eloquent, DateTime;

class Token extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'api_tokens';

	protected $fillable = array('user_id', 'token', 'lastuse_at');

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
	 * Update the lastuse_at value
	 */
	public function usedNow()
	{
		$this->lastuse_at = new DateTime;
		$this->save();
	}


}
