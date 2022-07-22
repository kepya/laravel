<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request){

    	session_start();

    	$request->session()->flush();

    	setcookie(session_name(),"",time()-3600);
		setcookie('token',"",time()-3600);

		$_SESSION = array();

		session_destroy();

		return redirect()->route('welcome');
    }
}
