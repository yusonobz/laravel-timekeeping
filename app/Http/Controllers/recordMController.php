<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\addUserRequest;
use App\Http\Controllers\Controller;
use App\User;
use App\Users;
use DB;
use Input;
use Auth;
class recordMController extends Controller
{
    //
        var $data = array();


        public function __construct()
        {
            $this->middleware('auth');
        }
    
        public function index()
    	{
            //account id
            // $this->data['users']= DB::table('users')
            // ->leftJoin('department', 'users.dep_id', '=', 'department.dep_id')
            // ->leftJoin('classification', 'users.class_id', '=', 'classification.class_id')
            // ->select(array('users.*', 'classification.class_name', 'department.dep_name'))
            // ->paginate(3); //record per page
            //$dataadd
            $user                               = new Users;
            $this->data['users']                = $user->getUsers();
            $this->data['classification']       = DB::table('classification')->get();
            $this->data['department']           = DB::table('department')->get();
            $this->data['accesslevel']          = DB::table('accesslevel')->get();
            $this->data['schedule']             = DB::table('schedule')->get();
            $this->data['position']             = DB::table('position')->get();
            $this->data['Image']                = DB::table('users')->where('id',Auth::user()->id)->get();
        	return view('page.recordM', $this->data);

    	}

        public function delete($id)
        {

            $userdelete             = new Users;

            $this->data['users']    = DB::table('users')->where('users.id',$id ) // gawin nyo to sa model hahahah
                                      ->delete();

            //return view('page.recordM', $this->data); 
            return redirect('/recordM');
        }


    	public function store(addUserRequest $request)
    	{


    	//SAVE USER///////////////////////////
    		$newuser = new Users;

    		$newuser->fname               = $request['fname'];
    		$newuser->mname               = $request['mname'];
    		$newuser->sname               = $request['sname'];
            $newuser->position_id         = $request['position'];
    		$newuser->dep_id              = $request['department'];
    		$newuser->class_id            = $request['classification'];
            $newuser->start_of_employment = $request['start_of_employment'];
            $newuser->email               = $request['email'];
            $newuser->password            =  bcrypt($request['password']);
            $newuser->accesslvl_id        = $request['accesslvl_id'];
            $newuser->sched_id            = $request['sched_id'];
    		$newuser->save();   
         
    		return redirect('/recordM');
    	}	

        public function changePassword(Request $request, $id)
        {
            $newPass                       = $request['pwd'];
            $changePass                    = new Users;
            $this->data['pass']            = $changePass->changePass($id, $newPass);
            \Session::flash('flash_message_error','Password Changed');
            //add edit commands
            // return $newPass . $id;
            return redirect('/recordM');
        }

        public function authChangepassword(Request $request)
        {
            //$currentPass                   = Auth::user()->password; 
            //$inputCurrpwd                  = bcrypt($request['currpwd']);
            $newPass                       = $request['pwd'];
            $confirmPass                   = $request['confirmpwd'];
            if($newPass == $confirmPass)
            {
            $id                            = Auth::user()->id;
            $changePass                    = new Users;
            $this->data['pass']            = $changePass->changePass($id, $newPass);
                if(Auth::user()->accesslvl_id == 1)
                {
                   \Session::flash('flash_message_error','Password Changed');
                    return redirect('/purpleBugTK');die;
                }
                else if(Auth::user()->accesslvl_id == 2)
                {
                    \Session::flash('flash_message_error','Password Changed');
                    return redirect('/user');die;
                }
            }
            else
            {
                if(Auth::user()->accesslvl_id == 1)
                {
                   \Session::flash('flash_message_error','Invalid Input');
                    return redirect('/purpleBugTK');die;
                }
                else if(Auth::user()->accesslvl_id == 2)
                {
                    \Session::flash('flash_message_error','Invalid Input');
                    return redirect('/user');die;
                }
            }
        }

        public function updatepage($id)
        {
            $getUser                            = new Users;
            $this->data['user']                 = $getUser->getSpecificUser($id);
            // var_dump($getUser->getSpecificUser($id));die;
            $this->data['classification']       = DB::table('classification')->get();
            $this->data['department']           = DB::table('department')->get();
            $this->data['accesslevel']          = DB::table('accesslevel')->get();
            $this->data['schedule']             = DB::table('schedule')->get();
            $this->data['position']             = DB::table('position')->get();
            return view('page.editEmployee', $this->data);
        }

        public function editEmployee(Request $request)
        {
            $id                                  = $request['id'];
            $fname                               = $request['fname'];   
            $mname                               = $request['mname'];
            $sname                               = $request['sname'];
            $dep_id                              = $request['department'];
            $class_id                            = $request['classification'];
            $accesslvl_id                        = $request['accesslvl_id'];
            $email                               = $request['email'];
            $sched_id                            = $request['sched_id'];
            $position_id                         = $request['position'];

            // var_dump($id . $fname . $mname . $sname .$position_id );die;
            $editUser                            = new Users;
            $this->data['edit']                  = $editUser->editInfo($id, $fname, $mname, $sname, $dep_id, $class_id, $accesslvl_id, $email, $sched_id, $position_id);
            return redirect('/recordM');
        }

}
