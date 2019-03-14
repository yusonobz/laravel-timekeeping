<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\attendanceRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use Auth;
use App\Attendance;
use Input;
use Carbon\Carbon;// import carbon
use Session;
use App\Users;
class employeeRecordController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
      
    public function index($id)
    {
        $userhistory                    = new Attendance;    
        $this->data['attendance']       = $userhistory->getUserHistory($id);
        $this->data['id']               = $id;
        $this->data['user']             = Users::find($id);
        $this->data['countMins']        = $userhistory->countMinsLate($id);
        $this->data['countHrs']         = $userhistory->countHrsRendered($id);
        $this->data['countUnderTime']   = $userhistory->countUnderTime($id);
        //var_dump($this->data['user']);die;
        return view('page.employeeRecord',$this->data);
       // return $this->data;
    }
    public function manualTimein(Request $request)
    {
        $id                                             = $request['emp_id'];
        $timein                                         = $request['timein'];
        $timeout                                        = $request['timeout'];
                            
        $time                                           = new Attendance;
        $time->emp_id                                   = $id;
        $time->time_in                                  = Carbon::now();        
        $time->time_out                                 = '00:00:00';
        $time->date                                     = Carbon::today();    
        $time->save();                                           
        $getID                                          = $time->att_id;
  

       // $this->date(format)a = $time->manualAdd($id, $timein, $timeout)
        $getLatestId = DB::table('attendance')->where('emp_id', '=', $id)->where('date', '=', Carbon::now()->format('Y-m-d'))->first();      

        $required_time_in                               = new Attendance;
        $required->data['attendance']                   = $required_time_in->getRequiredTimeIn($id);
        $in->data['attendance']                         = $required_time_in->getTimeIn($id,$getLatestId->att_id);
 
        $req_time_in                                    = $required->data['attendance']->time_in;
        $timed_in                                       = $in->data['attendance']->time_in;

        $car_req_time_in                                = Carbon::parse($req_time_in);
        $car_timed_in                                   = Carbon::parse($timed_in);

        $mins_diff                                      = $car_timed_in->diffInMinutes($car_req_time_in,false);

        if($mins_diff<0)
        {
          $diff   = abs($mins_diff);
          DB::table('attendance')->where('emp_id',$id)->where('att_id',$getID)->update(['mins_late'=> $diff]);
        }
        else
        {
          DB::table('attendance')->where('emp_id',$id)->where('att_id',$getID)->update(['mins_late'=> 0]);
        }
        
        ########## TO GET THE REMARK ###############
        if($timed_in<$req_time_in)
        {
          DB::table('attendance')->where('emp_id',$id)->where('att_id',$getID)->update(['status_id'=> 3]);
        }
        else
        {
          DB::table('attendance')->where('emp_id',$id)->where('att_id',$getID)->update(['status_id'=> 1]);
        }

        $userhistory                 = new Attendance;   
        $this->data['countMins']     = $userhistory->countMinsLate($id);
        $this->data['countHrs']      = $userhistory->countHrsRendered($id);

        return redirect('/employeeRecord/'.$id);

    }

    // public function individualtryextract(Request $request,$id)
    // {
    //     $from = $request['from'];
    //     $to = $request['to'];

    //     $tryxtract = new Attendance;
    //     $this->data['attendance'] = $tryxtract->individualExtractMonth($from,$to,$id);
    //     //var_dump($this->data);die;
      
    //     return view('page.employeeRecord',$this->data);
    // }
 
        
       
  



}
