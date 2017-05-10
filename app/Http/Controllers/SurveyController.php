<?php

namespace App\Http\Controllers;

use App\Surveys;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
	function index() {
		$surveys = Surveys::surveys();

		if ( $surveys ) {
			return response()->json( [
				'code' => 200,
				'data' => [ 'surveys' => $surveys, 'message' => 'success' ]
			], 200 );
		} else {
			return response()->json( [ 'code' => 404, 'data' => [ 'message' => 'Has no surveys' ] ], 404);
		}
	}

	function get( $id ) {
		$survey = Surveys::findOrFail( $id );

		if ( $survey ) {
			return response()->json( [
				'code' => 200,
				'data' => [ 'survey' => $survey, 'message' => 'success' ]
			], 200 );
		} else {
			return response()->json( [ 'code' => 400, 'data' => [ 'message' => 'Survey not exist' ], '404' ] );
		}
	}

	function create(Request $request) {
		$credentials = $request->only( 'title', 'content', 'isTemplate', 'default', 'result' );

		$survey = new Surveys();
		$survey->title = $credentials['title'];
		$survey->content = $credentials['content'];
		$survey->isTemplate = $credentials['isTemplate'];
		$survey->default = $credentials['default'];
		$survey->result = $credentials['result'];
		$survey->save();

		return response()->json(['code' => 200, 'data' => ['message' => 'Save Successfully!']]);
	}

	function edit(Request $request, $id) {
		$credentials = $request->only('title', 'content', 'isTemplate');

		$survey = Surveys::find($id);
		$survey->title = $credentials['title'];
		$survey->content = $credentials['content'];
		$survey->isTemplate = $credentials['isTemplate'];
		$survey->save();

		return response()->json(['code' => 200, 'data' => ['message' => 'Update Successfully!']]);
	}
}
