<?php

namespace App;
use DB;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    public function select()
    {
    	$users = DB::select('select * from user');
    	return $users;
    }

    public function insert($user)
    {
    	return DB::table('user')->insert($user);
    }

    public function checkExistName($name)
    {
    	$check_name = DB::table("user")
		->where("nama", "=", $name) 
		->get();

		if ($check_name) {
			return 1;
		}
		return 0;
    }
}
