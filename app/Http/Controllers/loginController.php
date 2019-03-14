<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Users;
use Session;

class loginController extends Controller
{	protected $request;
//	protected $redirectpath = '/';
//	protected $loginpath = '/purpleBugTK';
    var $data = array();
  public function index()
    {
        $this->data['message'] ='';
        if(Session::get('msg'))
        {
            $this->data['message']        =       Session::get('msg');
        }
    	return view('page.login')->with($this->data);
    }

  public function loguserin(Request $request)
    {

    	$this->data['users']       = DB::table('users')->get();

    	//return $request->get('email');	

    	if ( Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]) ) 
        {
    		$email                 = Auth::user()->email;

          if(Auth::user()->accesslvl_id != 1)
            {
                return redirect('/user');
            }
            else
            {
                return redirect('/purpleBugTK');
            }      		
    	}
    	else
    	{
    		//return "failed!";
            \Session::flash('flash_message_error','Invalid account');
    		return redirect('/');
    	}

    }

  public function getStatus(Request $request)
  {
 
        $email                      = Auth::user()->email;
        //return $email;
        $this->data['users']        = DB::table('users')->get('req_time_in');
        
        return redirect('/purpleBugTK');
    

  }

 public function logout(Request $request)
    {
        Auth::logout();
        \Session::flash('flash_message', 'Logged Out!');
        return redirect('/login');
    }
 public function trynormal()
    {
        return view('page.normalUser');
    }
    
}
