<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Users;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class timeKeepingController extends Controller
{
    //
    var $data = array();


    	public function __construct()
    	{
    	    $this->middleware('auth');
    	}
    
        public function index()
	    {
	    	$user 					= new Users;
	    	$this->data['users']	= $user->getUsersnopaginate();
            
	    	return view('page.timeKeeping',$this->data);

            // $user2                   = new Users;
            // $this->data['users2']    = $user2->getUsersnopaginate2();
            // return view('page.timeKeeping',$this->data['users2']);
        
	    }

        public function activate($user_id){
            $user = new Users;
            $user = $user->UserActivate($user_id);

            return redirect('/timeKeeping');die;
        
        }
                public function deactivate($user_id){
            $user = new Users;
            $user = $user->UserDeactivate($user_id);
              return redirect('/timeKeeping');die;
        }


}
