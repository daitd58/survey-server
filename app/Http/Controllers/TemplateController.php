<?php

namespace App\Http\Controllers;

use App\Surveys;
use Illuminate\Http\Request;

class TemplateController extends Controller {
	function index() {
		$templates = Surveys::templates();

		if ( $templates ) {
			return response()->json( [
				'code' => 200,
				'data' => [ 'templates' => $templates, 'message' => 'success' ]
			], 200 );
		} else {
			return response()->json( [ 'code' => 404, 'data' => [ 'message' => 'Has no templates' ] ], 404);
		}
	}

	function get( $id ) {
		$template = Surveys::findOrFail( $id );

		if ( $template ) {
			return response()->json( [
				'code' => 200,
				'data' => [ 'template' => $template, 'message' => 'success' ]
			], 200 );
		} else {
			return response()->json( [ 'code' => 400, 'data' => [ 'message' => 'Template not exist' ], '404' ] );
		}
	}

	function create(Request $request) {
		$credentials = $request->only( 'title', 'content', 'isTemplate', 'default', 'result' );

		$template = new Surveys();
		$template->title = $credentials['title'];
		$template->content = $credentials['content'];
		$template->isTemplate = $credentials['isTemplate'];
		$template->default = $credentials['default'];
		$template->result = $credentials['result'];
		$template->save();

		return response()->json(['code' => 200, 'data' => ['message' => 'Save Successfully!']]);
	}

	function edit(Request $request, $id) {
		$credentials = $request->only('title', 'content', 'isTemplate');

		$template = Surveys::find($id);
		$template->title = $credentials['title'];
		$template->content = $credentials['content'];
		$template->isTemplate = $credentials['isTemplate'];
		$template->save();

		return response()->json(['code' => 200, 'data' => ['message' => 'Update Successfully!']]);
	}

	function saveDefaultTemplate($id) {
		Surveys::resetDefaultTemplate();
		$template = Surveys::find($id);
		$template->default = true;
		$template->save();

		return response()->json(['code' => 200, 'data' => ['message' => 'success']]);
	}
}
