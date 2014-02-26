<?php
namespace Jeopardy\Token\Repositories;

use Auth;
use Carbon\Carbon;
use DateTime;
use Jeopardy\Token\Errors\TokenErrors;
use Jeopardy\Token\Exceptions\TokenException;
use Jeopardy\Token\Generators\TokenGeneratorInterface;
use Jeopardy\Token\Token;
use Log;
use Session;
use User;
use Validator;

class EloquentTokenRepository implements TokenRepositoryInterface
{
    /**
     * @var \Jeopardy\Token\Token
     */
    protected $tokenModel;

    /**
     * @var \Jeopardy\Token\Generators\TokenGeneratorInterface
     */
    protected $generator;

    /**
     * @var \User
     */
    protected $userModel;

    /**
     * Constructor
     *
     * @param Token                   $tokenModel
     * @param TokenGeneratorInterface $generator
     * @param User                    $userModel
     */
    public function __construct(Token $tokenModel, TokenGeneratorInterface $generator, User $userModel)
    {
        $this->tokenModel = $tokenModel;
        $this->generator  = $generator;
        $this->userModel  = $userModel;
    }

    /**
     * Generate a token
     *
     * @return string
     */
    private function generateToken()
    {
        Log::info('Generating token!');

        // Generate token
        $tokenStr = $this->generator->generate();

        // As long as the generated token already exist, generate a new one to check
        while (!$this->isTokenUnique($tokenStr)) {
            $tokenStr = $this->generator->generate();
        }

        return $tokenStr;
    }

    /**
     * Check if given token is unique
     *
     * @param  string $tokenStr
     *
     * @return boolean
     */
    private function isTokenUnique($tokenStr)
    {
        return !count($this->tokenModel->where('token', $tokenStr)->first());
    }

    /**
     * Get token instance from given token
     *
     * @param  string  $tokenStr
     * @param  boolean $forceDB
     *
     * @throws \Jeopardy\Token\Exceptions\TokenException
     * @return \Jeopardy\Token\Token
     */
    public function get($tokenStr, $forceDB = false)
    {
        Log::info('Getting token...');

        // If no token given throw exception
        if ($tokenStr == null) {
            throw new TokenException(TokenErrors::MISSING);
        }

        // If forced or session doesn't exist get from DB
        // Else get from session
        if ($forceDB == true || !Session::has($tokenStr)) {
            Log::info('...from db!');
            $token = $this->tokenModel->where('token', $tokenStr)->first();
            Session::put($tokenStr, serialize($token));
        } else {
            Log::info('...from session!');
            $token = unserialize(Session::get($tokenStr));
        }

        // If no token found throw exception
        if ($token == null) {
            throw new TokenException(TokenErrors::WRONG);
        }

        // If token is expired throw exception
        if (Carbon::parse($token->lastuse_at)->diffInDays() >= 1) {
            throw new TokenException(TokenErrors::EXPIRED);
        }

        return $token;
    }

    /**
     * Attempt to create a token for a user
     *
     * @param  array $credentials Must contain 'email' and 'password'
     *
     * @throws \Jeopardy\Token\Exceptions\TokenException
     * @return \Jeopardy\Token\Token
     */
    public function attempt(array $credentials)
    {
        Log::info('Attempting to create token!');

        // Validate credentials
        $validator = Validator::make($credentials, array(
                'email'    => array('required'),
                'password' => array('required')
            ));

        // If validation fails throw exception
        if ($validator->fails()) {
            throw new TokenException(TokenErrors::CREDENTIALSVALIDATION);
        }

        // If credentials is wrong throw exception
        if (!Auth::validate($credentials)) {
            throw new TokenException(TokenErrors::WRONGCREDENTIALS);
        }

        // Get user instance
        $user = $this->userModel->where('email', $credentials['email'])->first();

        // Create a token for this user
        return $this->create($user);
    }

    /**
     * Create a token for given user
     *
     * @param  User $user
     *
     * @return \Jeopardy\Token\Token
     */
    public function create(User $user)
    {
        Log::info('Creating token!');

        // Delete users existing token
        $this->purge($user);

        // Token array for creation
        $token = array(
            'user_id'    => $user->id,
            'token'      => $this->generateToken(),
            'lastuse_at' => new DateTime,
        );

        // Create the token and return it
        return $this->tokenModel->create($token);
    }

    /**
     * Delete given users existing token
     *
     * @param  User $user
     *
     * @return bool|null
     */
    public function purge(User $user)
    {
        Log::info('Deleting token!');

        return $user->token()->delete();
    }

    /**
     * Get user from given token
     *
     * @param  string $tokenStr
     * @param bool    $forceDB
     *
     * @return User
     */
    public function getUser($tokenStr, $forceDB = false)
    {
        Log::info('Getting tokens user!');

        $token = $this->get($tokenStr, $forceDB);

        return $token->user;
    }
}
