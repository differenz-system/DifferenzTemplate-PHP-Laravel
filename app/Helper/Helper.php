<?php

namespace App\Helper;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class Helper 
{
	public static function LoggedUser()
	{
		return User::where('UserId', Session::get('AdminId'))->first();
	}
}
?>