<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'subject_id', 'survey_id', 'teacher_id', 'year', 'semester'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
