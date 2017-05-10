<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surveys extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'isTemplate', 'title', 'content', 'default', 'result'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public static function templates() {
		return static::where('isTemplate', 1)->orderBy('title', 'desc')->get();
	}

	public static function surveys() {
		return static::where('isTemplate', 0)->orderBy('title', 'desc')->get();
	}

	public static function getTemplateDefault() {
		return static::where('default', true)->get();
	}

	public static function resetDefaultTemplate() {
		$surveys = Surveys::all();
		foreach($surveys as $survey) {
			$survey->default = false;
			$survey->save();
		}
	}
}
