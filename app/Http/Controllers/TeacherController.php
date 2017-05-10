<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Surveys;
use App\ClassStudent;
use App\Classes;
use App\Officers;

class TeacherController extends Controller
{
    public function getTeacherSurveys($id) {
    	$classes = Classes::where('teacher_id', $id)->get();
    	$surveys = [];
    	if($classes) {
    		foreach ($classes as $class) {
    			$survey = Surveys::findOrFail($class->survey_id);
    			array_push($surveys, $survey);
		    }
		    return response()->json(['code' => 200, 'data' => ['surveys' => $surveys, 'message' => 'success']], 200);
	    } else {
    		return response()->json(['code' => 204, 'data' => ['message' => 'The teacher has no class']], 204);
	    }
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

	function getTeacherInfo( $id ) {
    	$teacher = Officers::findOrFail( $id );

		if ( $teacher ) {
			return response()->json( [
				'code' => 200,
				'data' => [ 'teacher' => $teacher, 'message' => 'success' ]
			], 200 );
		} else {
			return response()->json( [ 'code' => 400, 'data' => [ 'message' => 'Teacher not exist' ] ], 204 );
		}
	}
}
