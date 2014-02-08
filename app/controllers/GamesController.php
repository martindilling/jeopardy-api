<?php

use Jeopardy\Responses\Api\ApiResponse;
use Jeopardy\Transformers\GameTransformer;
use League\Fractal\Manager;

class GamesController extends ApiController
{
    /**
     * @var array
     */
    protected $eagerLoad = array();

    //	/**
    //	 * @var integer
    //	 */
    //	protected $paginate;

    public function __construct()
    {
        parent::__construct(new Manager, new ApiResponse);

        //		// Get the requested pagination
        //		$requestedPagination = Input::get('paginate');
        //		// Set the pagination
        //		$this->paginate = $requestedPagination;

        // Get the requested embeds
        $requestedEmbeds = explode(',', Input::get('embed'));

        // Left is the embed names, right is relationship names.
        $possibleRelationships = array(
            'user'                            => 'user',
            'difficulties'                    => 'difficulties',
            'difficulties.questions.category' => 'difficulties.questions.category',
            'categories'                      => 'categories',
            'categories.questions'            => 'categories.questions',
            'categories.questions.difficulty' => 'categories.questions.difficulty',
        );

        // Check for potential ORM relationships, and convert from generic "embed" names
        $this->eagerLoad = array_values(array_intersect($possibleRelationships, $requestedEmbeds));
    }

    /**
     * Return all games for the user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Get user from token
        $user = $this->getTokenUser();

        //		if ( isset($this->paginate) ) {
        //			$games = Game::whereUserId($user->id)->paginate($this->paginate);
        //		} else {
        $games = $user->games;
        //		}

        // Eager load if any embeds
        if (!empty($this->eagerLoad)) {
            $games->load($this->eagerLoad);
        }

        return $this->respondWithCollection($games, new GameTransformer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $game = Game::find($id);

        // Is game found with the id
        if (!$game) {
            return ErrorResponse::singleResourceNotFound('game', $id);
        }

        // Eager load if any embeds
        if (!empty($this->eagerLoad)) {
            $game->load($this->eagerLoad);
        }

        return $this->respondWithItem($game, new GameTransformer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
