<?php
namespace Jeopardy\Token;

use DateTime;
use Eloquent;

/**
 * An Eloquent Model: 'Jeopardy\Token\Token'
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property \Carbon\Carbon $lastuse_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \User $user
 */
class Token extends Eloquent
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
    protected $table = 'api_tokens';

    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = array('user_id', 'token', 'lastuse_at');

    /**
     * Relationship: User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
