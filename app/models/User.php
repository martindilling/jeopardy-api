<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends BaseModel implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $fillable = array('email', 'password', 'name');

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Validation rules.
	 *
	 * @var array
	 */
	public static $rules = array(
		'email'    => 'required|email|unique:users',
		'password' => 'required|min:8',
		'name'     => 'required',
	);




	/**
	 * Relationship: Games
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function games()
	{
		return $this->hasMany('Game');
	}

	/**
	 * Relationship: ApiTokens
	 *
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function token()
	{
		return $this->hasOne('Jeopardy\Token\Token');
	}


	public function getToken()
	{
		return $this->token()->first();
	}




	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

}
