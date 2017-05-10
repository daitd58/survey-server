<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faculties extends Model
{
//	use Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'phone', 'website', 'office', 'location', 'dean'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
