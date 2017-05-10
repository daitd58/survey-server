<?php

namespace App\Http\Controllers;

use App\Officers;
use App\Surveys;
use App\Learners;
use Illuminate\Http\Request;
use App\Accounts;
use App\Http\Requests;
use Illuminate\Http\Response;
use JWTAuth;
use League\Flysystem\Exception;

class UserController extends Controller {
	public function index() {
		return view( 'auth.admin' );
	}

	public function login( Request $request ) {
		$credentials = $request->only( 'username', 'password' );

		if ( ! $token = JWTAuth::attempt( $credentials ) ) {
			return response()->json( [ 'code' => 401, 'data' => [ 'message' => 'Incorrect username or password' ] ], 401 );
		}
		$user = JWTAuth::toUser( $token );

		return response()->json( [ 'code' => 200, 'token' => $token, 'data' => $user ], 200 );
	}

	public function logout( Request $request ) {
		$this->guard()->logout();

		$request->session()->flush();

		$request->session()->regenerate();

		return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'Logout Success' ] ], 200 );
	}

	public function create( Request $request ) {
		$object = null;

		try {
			if ( intval( $request->user_type ) == 2 ) {
				$object                = new Staff();
				$object->department_id = null;
				$object->save();
			}

			if ( intval( $request->user_type ) == 3 ) {
				$object               = new Student();
				$object->student_code = null;
				$object->save();
			}

			$person_id = ( $object ) ? $object->id : null;

			$user = User::create( [
				'name'      => $request->name,
				'email'     => $request->email,
				'password'  => bcrypt( $request->password ),
				'user_type' => intval( $request->user_type ),
				'person_id' => $person_id
			] );
		} catch ( Exception $e ) {
			return response()->json( 404, [ 'message' => 'User already exists.' ] );
		}

		$token   = JWTAuth::fromUser( $user );
		$message = array( 'message' => 'Create user successfully!' );

		return response()->json( [ 'code' => 200, 'data' => [ 'message' => $message ] ], 200 );
	}

	public function get( $id ) {
		$user = User::find( $id );

		if ( $user ) {
			return response()->json( [ 'code' => 200, 'data' => $user, 'message' => 'success' ], 200 );
		} else {
			return response()->json( [ 'code' => 400, 'message' => 'error' ], 400 );
		}
	}

	public function update( $id, Request $request ) {

		$user            = User::find( $id );
		$user->name      = $request->name;
		$user->email     = $request->email;
		$user->user_type = $request->user_type;

		$user->save();

		return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'success' ] ], 200 );
	}

	public function delete( $id ) {
		$user = User::find( $id );
		if ( $user->user_type == 1 ) {
			return response()->json( [ 'code' => 400, 'data' => [ 'message' => 'error' ] ], 200 );
		} elseif ( $user->user == 2 ) {
			Staff::destroy( $user->person_id );
		} else {
			Student::destroy( $user->person_id );
		}

		$user->destroy( $id );

		return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'success' ] ], 200 );
	}

	public function users() {
		$users = User::get()->toArray();

		return response()->json( [ 'code' => 200, 'message' => 'successfully', 'data' => $users ], 200 );
	}

	public function templates() {
		$templates = Surveys::where( 'survey_type', 1 )->get()->toArray();

		return view( 'auth.templates', compact( 'templates' ) );
	}

	public function surveys() {
		$surveys = Surveys::where( 'survey_type', 2 )->get()->toArray();

		return view( 'auth.surveys', compact( 'surveys' ) );
	}

	public function notifications() {
		return view( 'auth.notifications' );
	}
}
