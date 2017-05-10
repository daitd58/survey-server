<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Learners extends Model
{
//	use Notifiable, HasApiTokens;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'type', 'fullname', 'otherEmail', 'phoneNumber', 'avatarUrl', 'class', 'learnerCode'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [];
}
