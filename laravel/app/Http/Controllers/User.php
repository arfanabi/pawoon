<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;
use App\Http\Requests;

class User extends Controller
{
    public function selectUser () 
    {
    	$userModel = new UserModel();
    	return $userModel->select();
    }

    public function addUser (Request $request)
    {
    	$userModel = new UserModel;
    	$userInput = $request->input('user');
		$userModel->insert($userInput);
    }

    public function checkName (Request $request)
    {
    	$userModel = new UserModel;
    	$name = $request->input('name');
    	return $userModel->checkExistName($name);
    }
}
