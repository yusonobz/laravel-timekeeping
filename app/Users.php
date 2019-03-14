<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Users extends Model
{
    //
	public function getUsers()
	{	//retrieve users
		        $data         =   DB::table('users')
                              ->leftJoin('department', 'users.dep_id', '=', 'department.dep_id')
                              ->leftJoin('classification', 'users.class_id', '=', 'classification.class_id')
                              ->leftJoin('position','users.position_id','=','position.id')
                              ->select(array('users.*', 'classification.class_name', 'department.dep_name', 'position.position_description'))
                              ->orderBy('sname','asc')
                              ->paginate(5); //record per page       
            return $data;
	}

  public function getUsersnopaginate()
  {
          $data         =   DB::table('users')
                            ->leftJoin('department', 'users.dep_id', '=', 'department.dep_id')
                            ->leftJoin('classification', 'users.class_id', '=', 'classification.class_id')
                            ->leftJoin('position','users.position_id','=','position.id')
                            ->select(array('users.*', 'classification.class_name', 'department.dep_name', 'position.position_description'))
                            // ->where('Employee_Status','=','Active')
                            ->paginate(222);//lol
          return $data;
  }
  // public function getUsersnopaginate2()
  // {
  //         $data         =   DB::table('users')
  //                           ->leftJoin('department', 'users.dep_id', '=', 'department.dep_id')
  //                           ->leftJoin('classification', 'users.class_id', '=', 'classification.class_id')
  //                           ->leftJoin('position','users.position_id','=','position.id')
  //                           ->select(array('users.*', 'classification.class_name', 'department.dep_name', 'position.position_description'))
  //                           ->where('Employee_Status','=','Inactive')
  //                           ->paginate(222);//lol
  //         return $data;
  // }
  public function changePass($id, $newPass)
  {
         DB::table('users')->where('id',$id)->update(['password'=> bcrypt($newPass)]);
  }

  public function getSpecificUser($id)
  {
          $data        =  DB::table('users')
                          ->leftJoin('department','users.dep_id','=','department.dep_id')
                          ->leftJoin('classification','users.class_id','=','classification.class_id')
                          ->leftJoin('position','users.position_id','=','position.id')
                          ->select('users.*')
                          ->where('users.id','=',$id)
                          ->get();
          return $data;
  }

  public function editInfo($id = '0', $fname = '', $mname = '', $sname = '', $dep_id = '0', $class_id = '0', $accesslvl_id = '0', $email = '', $sched_id = '0', $position_id = '0')
  {     
          DB::table('users')
              ->where('id',$id)
              ->update([
                'fname'             =>    $fname,
                'mname'             =>    $mname,
                'sname'             =>    $sname,
                'dep_id'            =>    $dep_id,
                'class_id'          =>    $class_id,
                'accesslvl_id'      =>    $accesslvl_id,
                'email'             =>    $email,
                'sched_id'          =>    $sched_id,
                'position_id'       =>    $position_id
                ]);
  }
  public function UserActivate($user_id){

    DB::table('users')->where('id',$user_id)->update(['Employee_Status' => 'Active']);

  }
    public function UserDeactivate($user_id){
    DB::table('users')->where('id',$user_id)->update(['Employee_Status' => 'Inactive']); 
  }
}
