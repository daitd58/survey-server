<?php

namespace App\Http\Controllers;

use App\Staff;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Departments;
use Illuminate\Auth\Access\Response;

class DepartmentController extends Controller {
	function index() {
		$departments = Departments::all()->toArray();

		// add department parent
		for ( $i = 0; $i < count( $departments ); $i ++ ) {
			if ( $parent = Departments::select( 'department_name' )->where( 'id', $departments[ $i ]['parent_id'] )->first() ) {
				$departments[ $i ]['parent'] = $parent->department_name;
			} else {
				$departments[ $i ]['parent'] = 'Không có';
			}
		}

		return response()->json( [ 'code' => 200, 'message' => 'success', 'data' => $departments ], 200 );
	}

	function get_create() {
		$departments = Departments::all()->toArray();
		$staff       = Staff::all()->toArray();
		$staff_id    = [];
		foreach ( $staff as $item ) {
			$staff_id[] = $item['id'];
		}
		$user_staff = User::select( 'person_id', 'name' )->whereIn( 'person_id', $staff_id )->where( 'user_type', 2 )->get()->toArray();

		return response()->json(['code' => 200, 'data' => ['user_staff' => $user_staff, 'departments' => $departments]]);
	}

	function post_create( Request $request ) {
		$department                  = new Departments();
		$department->department_name = $request['department_name'];
		$department->parent_id       = $request['parent_id'];
		$department->save();

		$staff = $request['staff'];
		if ( is_array( $staff ) ) {
			foreach ( $staff as $id ) {
				Staff::where( 'id', $id )->update( [ 'department_id' => $department->id ] );
			}
		} else {
			Staff::where( 'id', $staff )->update( [ 'department_id' => $department->id ] );
		}

		return response()->json(['code' => 200, 'data' => ['message' => 'success']]);
	}

	function get_edit( $id ) {
		$department       = Departments::find( $id )->toArray();
		$departments      = Departments::all()->toArray();
		$staff_department = Departments::find( $id )->staff_id();
		$all_staff        = Staff::all()->toArray();
		$staff_id         = [];
		foreach ( $all_staff as $item ) {
			$staff_id[] = $item['id'];
		}
		$user_staff = User::select( 'person_id', 'name' )->whereIn( 'person_id', $staff_id )->where( 'user_type', 2 )->get()->toArray();

		return response()->json( [
			'code'    => 200,
			'data'    => [
				'department'       => $department,
				'staff_department' => $staff_department,
				'departments'      => $departments,
				'user_staff'       => $user_staff
			],
			'message' => 'success'
		], 200 );
	}

	function post_edit( Request $request, $id ) {
		$department                  = Departments::find( $id );
		$department->department_name = $request['department_name'];
		$department->parent_id       = $request['parent_id'];
		$department->save();

		$staff = $request['staff'];
		$staff_department = Departments::find($id)->staff()->get();
		foreach ($staff_department as $item ) {
			Staff::find($item->id)->update( ['department_id' => null] );
		}
		if ( is_array( $staff ) ) {
			foreach ( $staff as $id ) {
				Staff::where( 'id', $id )->update( [ 'department_id' => $department->id ] );
			}
		} else {
			Staff::where( 'id', $staff )->update( [ 'department_id' => $department->id ] );
		}

		return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'success' ] ], 200 );
	}

	function delete( $id ) {
		$staff = Staff::where( 'department_id', $id )->get();

		foreach ( $staff as $item ) {
			$item->department_id = null;
			$item->save();
		}

		Departments::where( 'parent_id', $id )->update( [ 'parent_id' => 0 ] );
		Departments::destroy( $id );

		return response()->json( [ 'code' => 200, 'data' => [ 'message' => 'success' ] ], 200 );
	}
}