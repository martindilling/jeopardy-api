<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;

/**
 * An Eloquent Model: 'User'
 *
 * @property integer                                               $id
 * @property string                                                $email
 * @property string                                                $password
 * @property string                                                $name
 * @property \Carbon\Carbon                                        $created_at
 * @property \Carbon\Carbon                                        $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Game[] $games
 * @property-read \Jeopardy\Token\Token                            $token
 */
class User extends BaseModel implements UserInterface, RemindableInterface
{
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
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = array('email', 'password', 'name');

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    /**
     * Relationship: Games
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function games()
    {
        return $this->hasMany('Game');
    }

    public function getToken()
    {
        return $this->token()->first();
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
