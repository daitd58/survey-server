<?php
/**
 * Created by PhpStorm.
 * User: daitd
 * Date: 07/12/2016
 * Time: 01:43
 */

function get_departments( $data, $parent = 0, $str = '--', $select = 0 ) {
	foreach ( $data as $item ) {
		$id   = $item['id'];
		$name = $item['department_name'];
		if ( $item['parent_id'] == $parent ) {
			if ( $select != 0 && $id == $select ) {
				echo "<option value='$id' selected='selected'>$str $name</option>";
			} else {
				echo "<option value='$id'>$str $name</option>";
			}
			get_departments( $data, $id, $str . "--", $select );
		}
	}
}

function get_department_parent( $id ) {
	if ( $id != 0 ) {
		$parent = DB::table( 'departments' )->where( 'id', $id )->first();
		echo $parent->department_name;
	} else {
		echo 'None';
	}
}