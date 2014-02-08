<?php

use Jeopardy\Transformers\UserTransformer;

class UsersController extends ApiController
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @var array
     */
    protected $eagerLoad = array();

    //	/**
    //	 * @var integer
    //	 */
    //	protected $paginate;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;

        //		// Get the requested pagination
        //		$requestedPagination = Input::get('paginate');
        //		// Set the pagination
        //		$this->paginate = $requestedPagination;

        // Get the requested embeds
        $requestedEmbeds = explode(',', Input::get('embed'));

        // Left is the embed names, right is relationship names.
        $possibleRelationships = array(
            'games'                                 => 'games',
            'games.difficulties'                    => 'games.difficulties',
            'games.difficulties.questions.category' => 'games.difficulties.questions.category',
            'games.categories'                      => 'games.categories',
            'games.categories.questions'            => 'games.categories.questions',
            'games.categories.questions.difficulty' => 'games.categories.questions.difficulty',
        );

        // Check for potential ORM relationships, and convert from generic "embed" names
        $this->eagerLoad = array_values(array_intersect($possibleRelationships, $requestedEmbeds));
    }

    /**
     * Create a new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $validation = User::validate(Input::all());

        if ($validation->passes()) {
            $user           = new User;
            $user->email    = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->name     = Input::get('name');
            $user->save();

            return $this->setStatusCode(201)->respondWithItem($user, new UserTransformer);
        } else {
            return ErrorResponse::createResourceValidationError($validation->messages()->toArray(), Input::except('password'));
        }
    }

    /**
     * Get the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        // Get user from token
        $user = $this->getTokenUser();

        // Eager load if any embeds
        if (!empty($this->eagerLoad)) {
            $user->load($this->eagerLoad);
        }

        return $this->respondWithItem($user, new UserTransformer);
    }

    /**
     * Update the authenticated user
     *
     * @param null $id
     *
     * @return string
     */
    public function update($id = null)
    {
        return 'TODO: Update the user';
    }

    /**
     * Delete the authenticated user
     *
     * @param null $id
     *
     * @return string
     */
    public function destroy($id = null)
    {
        return 'TODO: Delete the user';
    }
}
