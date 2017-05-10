<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
//	use Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'facultyId', 'office', 'phone', 'dean'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
