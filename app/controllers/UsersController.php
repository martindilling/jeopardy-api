<?php

use Jeopardy\Transformers\UserTransformer;

class UsersController extends ApiController {

	protected $user;

	public function __construct(User $user)
	{
		parent::__construct(new League\Fractal\Manager, new Jeopardy\Responses\Api\ApiResponse);
		$this->user = $user;
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$users = User::take(10)->get();

		return $this->respondWithCollection($users, new UserTransformer);
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
		// return Input::all();
		$validation = User::validate(Input::all());
		if ($validation->passes()){

			$user = new User;
			$user->email    = Input::get('email');
			$user->password = Hash::make(Input::get('password'));
			$user->name     = Input::get('name');
			// $user->generateApiToken();
			$user->save();

			return $this->setStatusCode(201)->respondWithItem($user, new UserTransformer);
		}
		else {
			// dd($validation->messages()->toJson());
			return ErrorResponse::createResourceValidationError($validation->messages()->toArray(), Input::except('password'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$user = User::find($id);

		if (! $user) {
			return ErrorResponse::singleResourceNotFound('user', $id);
		}

		return $this->respondWithItem($user, new UserTransformer);
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
