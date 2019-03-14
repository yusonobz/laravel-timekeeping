<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\attendanceRequest;
use App\Http\Requests\OBRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Auth;
use App\Attendance;
use Input;
use Carbon\Carbon;// import carbon
use Session;

class purpleBugTKController extends Controller
{		protected $request;
        
    //
      public function __construct()
      {
          $this->middleware('auth');
      }
      
      public function index()
   	 	{
        $attendance                 = new Attendance;
        $this->data['attendance']   = $attendance->getAttendance();
        // die(var_dump($this->data['attendance']));
    	  return view('page.purpleBugTK', $this->data);

    	}

      public function undertimeTry($id)
      {
        $getTime                    = new Attendance;
        $this->data['time_out']     = $getTime->getRequiredTimeOut($id);
        echo '<pre>';
        die(var_dump($this->data));
      }
      public function obtimein(OBRequest $request)
      {   

        $OBouts = Input::get('time_out');
        $OBin = Input::get('time_in');
        $empid = Auth::user()->id;
        $OBDate = Input::get('Date');

        $check_OB         = new Attendance;
        $this->data['OBattendance'] = $check_OB->getObInOut($empid,$OBDate);   
       if(!is_null($this->data['OBattendance']))
       {
          
        if($this->data['OBattendance']->Date == Carbon::now()->format('Y-m-d') && $this->data['OBattendance']->att_id == '0' )
          {
                    \Session::flash('flash_message_error','You have pending Official Business Request for Today');
             if(Auth::user()->accesslvl_id != 1)
              {
                  return redirect('/user');
                  die;
               }
              else
              {
                  return redirect('/purpleBugTK');
                  die;
               } 
           }
        }
        if ($OBin < $OBouts && $OBDate >= Carbon::now()->format('Y-m-d'))
        {

       //        $checkPendingRequest         = new Attendance;
       // $checkerForPending = $checkPendingRequest->check_attendance($OBDate);   
       // $getID = '';
          $UserReqName = DB::table('users')->where('id','=',$empid)->first();
          $OBfname = $UserReqName->fname;
          $Osname = $UserReqName->sname;
     
          $ObAttendance = new Attendance;
          $ObAttendance->OBout($empid,$OBouts,$OBin,$OBDate,$OBfname,$Osname);
  
              return redirect('/obrequestlist');

          }else
            {
              \Session::flash('flash_message_error',' Duration of Official Business is not valid');
             if(Auth::user()->accesslvl_id != 1)
              {
                  return redirect('/user');
                  die;
              }
              else
              {
                  return redirect('/purpleBugTK');
                  die;
              }  
            }
      }

          public function OBRequestList()
    {
      ### Retrieve Official Business Request ####
        $id = Auth::user()->id;
        $OBattendance                             = new Attendance;
        $this->data['OBattendance']               = $OBattendance->getOBAttendance($id);
        $this->data['Image']                      =DB::table('users')->where('id',Auth::user()->id)->get();
         return view('page.obreq', $this->data);


    }

    	public function timein(attendanceRequest $request)
    	{  

        $empID = Auth::user()->id;
        $check_attendance = new attendance;
        $this->data['attendance'] = $check_attendance->getLatestatt_id();

        $check_OB         = new Attendance;
        $this->data['OBattendance'] = $check_OB->getObInOut2($empID);   
     
       if(!is_null($this->data['OBattendance']))
       {
          
        if($this->data['OBattendance']->Date == Carbon::now()->format('Y-m-d') && $this->data['attendance']->att_id == '0' )
          {
                    \Session::flash('flash_message_error','You have pending Official Business Request for Today');
             if(Auth::user()->accesslvl_id != 1)
              {
                  return redirect('/user');
                  die;
              }
              else
              {
                  return redirect('/purpleBugTK');
                  die;
              } 
           }
        }

       if(!is_null($this->data['attendance']))
       {
          
        if($this->data['attendance']->date == Carbon::now()->format('Y-m-d') && Carbon::now() > $this->data['attendance']->time_in )
          {
                    \Session::flash('flash_message_error','Your Existing Time in is earlier than current time');
             if(Auth::user()->accesslvl_id != 1)
              {
                  return redirect('/user');
                  die;
              }
              else
              {
                  return redirect('/purpleBugTK');
                  die;
              } 
           }

           else
           {
              $newattendance = new Attendance;
              $newattendance = $newattendance->newattendance($empID);
            }




       }else{
        $newattendance                = new Attendance;
        $newattendance->emp_id        = Auth::user()->id;
        $newattendance->time_in       = Carbon::now();        
        $newattendance->time_out      = '00:00:00';
        $newattendance->date          = Carbon::today();    
        $newattendance->save(); 
        $getID                        = $newattendance->att_id;
        Session::put('atID',$getID);   
       }


           
        $getLatestId                  = DB::table('attendance')->where('emp_id', '=', Auth::user()->id)->where('date', '=', Carbon::now()->format('Y-m-d'))->first();      
  
        $required_time_in             = new Attendance;
        $required->data['attendance'] = $required_time_in->getRequiredTimeIn(Auth::user()->id);
        $in->data['attendance']       = $required_time_in->getTimeIn(Auth::user()->id,$getLatestId->att_id);

            


        $req_time_in                  = $required->data['attendance']->time_in;
        $timed_in                     = $in->data['attendance']->time_in;

        $car_req_time_in              = Carbon::parse($req_time_in);
        $car_timed_in                 = Carbon::parse($timed_in);


        ########## TO GET THE MINS LATE ###############

        $mins_diff                    = $car_timed_in->diffInMinutes($car_req_time_in,false);

        if($mins_diff<0)
        {
          $diff     = abs($mins_diff);
          DB::table('attendance')->where('emp_id',Auth::user()->id)->where('att_id',$getID)->update(['mins_late'=> $diff]);
        }
        else
        {
          DB::table('attendance')->where('emp_id',Auth::user()->id)->where('att_id',$getID)->update(['mins_late'=> 0]);
        }
        
        ########## TO GET THE REMARK ###############
        if($timed_in<$req_time_in)
        {
          DB::table('attendance')->where('emp_id',Auth::user()->id)->where('att_id',$getID)->update(['status_id'=> 3]);
        }
        else
        {
          DB::table('attendance')->where('emp_id',Auth::user()->id)->where('att_id',$getID)->update(['status_id'=> 1]);
        }
        

        ###########ACCESS LEVEL REDIRECT############
        if(Auth::user()->accesslvl_id != 1)
        {
            return redirect('/user');
        }
        else
        {
            return redirect('/purpleBugTK');
        }  
      }
      public function timeout(attendanceRequest $request, $id)
      {   
            $check_attendance         = new Attendance;
            $this->data['attendance'] = $check_attendance->getLatestatt_id();     
            $dt=Carbon::now();

            $time=$dt->hour.':' .$dt->second;

            if(!is_null($this->data['attendance'])){


           if ($this->data['attendance']->time_out > $time && carbon::now()->format('Y-m-d') == $this->data['attendance']->date )
             {

            \Session::flash('flash_message_error','Current time is earlier than existing time out');
           if(Auth::user()->accesslvl_id != 1)
              {
                  return redirect('/user');
                  die;
              }
           else
              {
                  return redirect('/purpleBugTK');
                  die;
              } 


        }else{

       $getLatestId                    = DB::table('attendance')->where('emp_id', '=', Auth::user()->id)->where('date', '=', Carbon::now()->format('Y-m-d'))->first();      
        DB::table('attendance')->where('att_id', '=', $getLatestId->att_id)->update(['time_out'=> Carbon::now()]);
        //delete update clause
        $hours_rendered = new Attendance;
        $timein->data['attendance']     = $hours_rendered->getTimeIn(Auth::user()->id,$getLatestId->att_id);
        $timeout->data['attendance']    = $hours_rendered->getTimeOut(Auth::user()->id,$getLatestId->att_id);

        $att_time_in                    = $timein->data['attendance']->time_in;
        $att_time_out                   = $timeout->data['attendance']->time_out;

        $tmp_TimeIn                     = Carbon::parse($att_time_in);
        $tmp_TimeOut                    = Carbon::parse($att_time_out);

        $computed_hrs                   = $tmp_TimeIn->diffInHours($tmp_TimeOut, false);
        $computed_minues                = $tmp_TimeIn->diffInMinutes($tmp_TimeOut, false);
        //CHECK HOURS RENDERED DEDUCTION - LUNCH TIME
        ////////////////////////////////////////////////////

        $obj                          = new Attendance;
        $out->data['attendance']      = $obj->getTimeOut(Auth::user()->id,$getLatestId->att_id);
        $time_out                     = $out->data['attendance']->time_out;
        $car_time_out                 = Carbon::parse($time_out);

        $required->data['attendance'] = $obj->getRequiredTimeOut(Auth::user()->id);
        $req_time_out                 = $required->data['attendance']->time_out;
        $car_req_time_out             = Carbon::parse($req_time_out);


        $undertime_val                = ($car_time_out->diffInMinutes($car_req_time_out, false))/60;
        // var_dump($req_time_out . '   '.$time_out.  '     '.$undertime_val);die;
        DB::table('attendance')->where('att_id','=',$getLatestId->att_id)->update(['under_time'=>$undertime_val]);
        ////////////////////////////////////////////////////////


         if($att_time_in < '12:00:00' && $att_time_out > '12:00:00')
         {
         $computed_hrs                  = $computed_hrs - 1; 
         //$computed_hrs   = $tmp_TimeIn->diffInHours($tmp_TimeOut, false);
         }
         else if($att_time_in > '12:00:00')
         {
         $computed_hrs                  = $tmp_TimeIn->diffInHours($tmp_TimeOut, false);//$hrs_rendered = ((strtotime($att_time_out) - strtotime($att_time_in))/60)/60; //hours rendered to hours
         }
         DB::table('attendance')->where('emp_id','=',Auth::user()->id)->where('att_id','=',$getLatestId->att_id)->update(['hrs_rendered'=> $computed_hrs]);

        if(Auth::user()->accesslvl_id != 1)
        {
            return redirect('/user');
        }
        else
        {
            return redirect('/purpleBugTK');
        }  
        }
  }else{
        \Session::flash('flash_message_error','You dont have existing time in');
    if(Auth::user()->accesslvl_id != 1)
        {
            return redirect('/user');die;
        }
        else
        {
            return redirect('/purpleBugTK');die;
        }  
}
}

        public function diff($id)
      {

             $time                        = new Attendance;   
             $a->data['attendance']       = $time->getTimeIn($id);
             $b->data['attendance']       = $time->getTimeOut($id);
            
             $checkdiff                   = new Attendance;
             $rti->data['attendance']     = $checkdiff->getRequiredTimeIn($id);
             $to->data['attendance']      = $checkdiff->getTimeOut($id);         //*******************n.a

          return $a->data['attendance'];
      }

        public function checktimein($id)
      {
            $required_time_in             = new Attendance;
            $required->data['attendance'] = $required_time_in->getRequiredTimeIn($id);
            $in->data['attendance']       = $required_time_in->getTimeIn($id);

           return $required->data['attendance'];  
      }

      public function timecheck()
      {

        if(Carbon::now() < '12:00:00')
        {
          return 'true';
        }
        else
        {
          return 'false';
        }
      }

      public function whosIn()
      {
        $timed_in                 = new Attendance;
        $this->data['attendance'] = $timed_in->whosIn();
        $this->data['Image']      = DB::table('users')->where('id',Auth::user()->id)->get();
        //var_dump($this->data);die;
        return view('page.whosin',$this->data);
        //return new blade with this->data;

      }

      public function obgrant($OB_emp_id){


       $ObRequest=DB::table('request_status')->where('emp_id','=',$OB_emp_id)->where('Request_Status','=','Pending')->first();
       $ObRequestID = $ObRequest->id;
       $ObRequestDate = $ObRequest->Date;
       $ObRequestIn = $ObRequest->Request_In;
       $ObRequestOut = $ObRequest->Request_Out;
       $ObRequestStatus = 'Granted';

      $checkExistLog = DB::table('attendance')->where('date','=',$ObRequestDate)->where('emp_id',$OB_emp_id)->first();



       if(!is_null($checkExistLog)){
            $attID = $checkExistLog->att_id;
            $update = array('time_out'=>$ObRequestOut,'Log_Mode_Id'=>'2','Request_Status_ID'=>$ObRequestID);
            $ObUpdateAttendance = new Attendance;
            DB::table('attendance')->where('att_id',$attID)->where('date','=',$ObRequestDate)->where('emp_id','=',$OB_emp_id)->update($update);
      }else{
          $ObAttendance = new Attendance;
          $ObAttendance->ObNewAttendance($OB_emp_id,$ObRequestDate,$ObRequestIn,$ObRequestOut,$ObRequestID);
          $getattendanceID = DB::table('attendance')->where('emp_id','=',$OB_emp_id)->where('date','=',$ObRequestDate)->first();
          $attID = $getattendanceID->att_id;
          }



          $UpdateObRequest = new Attendance;
          $UpdateObRequest->UpdateRequest($attID,$ObRequestID);

          $required_time_in             = new Attendance;
          $required->data['attendance'] = $required_time_in->getOBRequiredTimeIn($OB_emp_id);

          $req_time_in                  = $required->data['attendance']->time_in;
        if(!is_null($checkExistLog)){
$ExistingTimeIn = DB::table('attendance')->where('date','=',$ObRequestDate)->where('emp_id',$OB_emp_id)->first();
$timed_in  =   $ExistingTimeIn->time_in;
        }else{
          $timed_in                     = $ObRequestIn;
        }



          $car_req_time_in              = Carbon::parse($req_time_in);
          $car_timed_in                 = Carbon::parse($timed_in);


          $mins_diff                    = $car_timed_in->diffInMinutes($car_req_time_in,false);

        if($mins_diff<0)
        {
          $diff     = abs($mins_diff);
          DB::table('attendance')->where('emp_id',$OB_emp_id)->where('att_id',$attID)->update(['mins_late'=> $diff]);
        }
        else
        {
          DB::table('attendance')->where('emp_id',$OB_emp_id)->where('att_id',$attID)->update(['mins_late'=> 0]);
        }
        
        ########## TO GET THE REMARK ###############
        if($timed_in<$req_time_in)
        {
          DB::table('attendance')->where('emp_id',$OB_emp_id)->where('att_id',$attID)->update(['status_id'=> 5]);
        }
        else
        {
          DB::table('attendance')->where('emp_id',$OB_emp_id)->where('att_id',$attID)->update(['status_id'=> 6]);
        }

        $tmp_TimeIn                     = Carbon::parse($ObRequestIn);
        $tmp_TimeOut                    = Carbon::parse($ObRequestOut);

        $computed_hrs                   = $tmp_TimeIn->diffInHours($tmp_TimeOut, false);
        $computed_minues                = $tmp_TimeIn->diffInMinutes($tmp_TimeOut, false);
        //CHECK HOURS RENDERED DEDUCTION - LUNCH TIME
        ////////////////////////////////////////////////////

        $car_time_out                 = Carbon::parse($ObRequestOut);
        $obj                          = new Attendance;
        $required->data['attendance'] = $obj->getRequiredTimeOut(Auth::user()->id);
        $req_time_out                 = $required->data['attendance']->time_out;
        $car_req_time_out             = Carbon::parse($req_time_out);


        $undertime_val                = ($car_time_out->diffInMinutes($car_req_time_out, false))/60;
        // var_dump($req_time_out . '   '.$time_out.  '     '.$undertime_val);die;
        DB::table('attendance')->where('att_id','=',$attID)->update(['under_time'=>$undertime_val]);
        ////////////////////////////////////////////////////////


         if($ObRequestIn < '12:00:00' && $ObRequestOut > '12:00:00')
         {
         $computed_hrs                  = $computed_hrs - 1; 
         //$computed_hrs   = $tmp_TimeIn->diffInHours($tmp_TimeOut, false);
         }
         else if($ObRequestIn > '12:00:00')
         {
         $computed_hrs                  = $tmp_TimeIn->diffInHours($tmp_TimeOut, false);//$hrs_rendered = ((strtotime($att_time_out) - strtotime($att_time_in))/60)/60; //hours rendered to hours
         }
         DB::table('attendance')->where('emp_id','=',$OB_emp_id)->where('att_id','=',$attID)->update(['hrs_rendered'=> $computed_hrs]);


         if(Auth::user()->accesslvl_id != 1)
        {
            return redirect('/user');
        }
        else
        {
            return redirect('/purpleBugTK');
        }  

      }
       public function Deny($OB_emp_id){

        $ObDeny = new attendance;
        $OBDenied = $ObDeny->UpdateRequestDeny($OB_emp_id);

          if(Auth::user()->accesslvl_id != 1)
        {
            return redirect('/user');die;
        }
        else
        {
            return redirect('/purpleBugTK');die;
        }  
       }

}
