<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officers extends Model
{
//	use Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'isAdmin', 'isLecturer', 'fullname', 'otherEmail', 'phoneNumber', 'avatarUrl', 'class', 'office', 'officerCode'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
