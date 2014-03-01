<?php

use Jeopardy\Transformers\QuestionTransformer;

class QuestionsController extends ApiController
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
            'category'                            => 'category',
            'category.game'                       => 'category.game',
            'category.game.user'                  => 'category.game.user',
            'difficulty'                          => 'difficulty',
        );

        // Check for potential ORM relationships, and convert from generic "embed" names
        $this->eagerLoad = array_values(array_intersect($possibleRelationships, $requestedEmbeds));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($category_id)
    {
        $game = Game::whereHas('categories', function($query) use ($category_id)
        {
            $query->where('id', $category_id);
        })->first();

        // Is game found with the id
        if (!$game) {
            return ErrorResponse::singleResourceNotFound('category', $category_id);
        }

        if ($game->user_id != $this->currentUser->id) {
            return ErrorResponse::singleResourceUnauthorized('game', $game->id);
        }

        $questions = $game->categories()->where('id', $category_id)->first()->questions;

         // Is game found with the id
        if (!$questions) {
            return ErrorResponse::nothingCreatedYet('questions');
        }

        return $this->respondWithCollection($questions, new QuestionTransformer);
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
            $query->whereHas('questions', function($query2) use ($id)
            {
                $query2->where('id', $id);
            });
        })->first();

        // Check if user is authorized to view this
        if ($game->user_id != $this->currentUser->id) {
            return ErrorResponse::singleResourceUnauthorized('game', $game->id);
        }

        $question = Question::find($id);

        // Does the question with $id exist
        if (!$question) {
            return ErrorResponse::singleResourceNotFound('question', $id);
        }

        return $this->respondWithItem($question, new QuestionTransformer);
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
