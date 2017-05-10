<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Surveys;
use App\ClassStudent;
use App\Classes;

class StudentController extends Controller
{
	public function getStudentSurveys( $id ) {
		$surveys = [];
		$classStudent = ClassStudent::where('student_id', $id)->get();
		foreach ($classStudent as $item) {
			$class = Classes::findOrFail($item->class_id);
			$survey = Surveys::findOrFail($class->survey_id);
			array_push($surveys, $survey);
		}

		if($surveys) {
			return response()->json(['data' => ['surveys' => $surveys, 'message' => 'success']], 200);
		}

		return response()->json(['data' => ['code' => 204, 'message' => 'Has no surveys']], 204);
	}

	function getSurvey( $id ) {
		$survey = Surveys::findOrFail( $id );

		if ( $survey ) {
			return response()->json( [
				'code' => 200,
				'data' => [ 'survey' => $survey, 'message' => 'success' ]
			], 200 );
		} else {
			return response()->json( [ 'code' => 400, 'data' => [ 'message' => 'Survey not exist' ] ], 204 );
		}
	}

	function submitSurvey( Request $request, $id ) {
		$survey = Surveys::findOrFail( $id );
		$credentials = $request->only('user_id', 'data');
		if( $survey ) {
			$result = $survey->result;
			if($result) {
				$result = json_decode($result);
				array_push($result, $credentials);
				$result = json_encode($result);
				$survey->result = $result;
				$survey->save();
				return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'success' ] ], 200 );
			} else {
				$result = [];
				array_push($result, $credentials);
				$survey->result = json_encode($result);
				$survey->save();
				return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'success' ] ], 200 );
			}
		} else {
			return response()->json( [ 'code' => 400, 'data' => [ 'message' => 'Survey not exist' ] ], 204 );
		}
	}
}
