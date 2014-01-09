<?php

use Jeopardy\Transformers\GameTransformer;

class GamesController extends ApiController {

	protected $eagerLoad = array();

	public function __construct()
	{
		parent::__construct(new League\Fractal\Manager);

		$requestedEmbeds = explode(',', Input::get('embed'));

		// Left is the embed names, right is relationship names.
		// avoids exposing relationships and whatnot directly
		$possibleRelationships = array(
			'user'                   => 'user',
			'difficulties'           => 'difficulties',
			'difficulties.questions' => 'difficulties.questions',
			'categories'             => 'categories',
			'categories.questions'   => 'categories.questions',
		);

		// Check for potential ORM relationships, and convert from generic "embed" names
		$this->eagerLoad = array_values(array_intersect($possibleRelationships, $requestedEmbeds));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$games = Game::with($this->eagerLoad)->take(10)->get();

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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$game = Game::with($this->eagerLoad)->find($id);

		if (! $game) {
			return $this->errorNotFound('Did you just invent an ID and try loading a game? Muppet.');
		}

		return $this->respondWithItem($game, new GameTransformer);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
