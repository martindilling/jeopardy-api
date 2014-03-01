<?php

use Jeopardy\Transformers\CategoryTransformer;

class CategoriesController extends ApiController
{
    /**
     * @var array
     */
    protected $eagerLoad = array();

    /**
     * @var User
     */
    protected $currentUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->currentUser = $this->getTokenUser();

        // Get the requested embeds
        $requestedEmbeds = explode(',', Input::get('embed'));

        // Left is the embed names, right is relationship names.
        $possibleRelationships = array(
            'game'                            => 'game',
            'game.user'                       => 'game.user',
            'questions'                       => 'questions',
            'questions.difficulty'            => 'questions.difficulty',
        );

        // Check for potential ORM relationships, and convert from generic "embed" names
        $this->eagerLoad = array_values(array_intersect($possibleRelationships, $requestedEmbeds));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($game_id)
    {
        $game = Game::find($game_id);

        // Is game found with the id
        if (!$game) {
            return ErrorResponse::singleResourceNotFound('game', $game_id);
        }

        if ($game->user_id != $this->currentUser->id) {
            return ErrorResponse::singleResourceUnauthorized('game', $game_id);
        }

        $categories = $game->categories()->orderBy('order', 'asc')->get();

         // Is game found with the id
        if (!$categories) {
            return ErrorResponse::nothingCreatedYet('categories');
        }

        return $this->respondWithCollection($categories, new CategoryTransformer);
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
        // Get game that has a category with $id
        $game = Game::whereHas('categories', function($query) use ($id)
        {
            $query->where('id', $id);
        })->first();

        // Check if user is authorized to view this
        if ($game->user_id != $this->currentUser->id) {
            return ErrorResponse::singleResourceUnauthorized('game', $game->id);
        }

        // Get the category with $id from the game
        $category = $game->categories()->where('id', $id)->first();

        // Does the category with $id exist
        if (!$category) {
            return ErrorResponse::singleResourceNotFound('category', $id);
        }

        return $this->respondWithItem($category, new CategoryTransformer);
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
