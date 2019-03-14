<?php
namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use Carbon\Carbon;
class Attendance extends Model
{
    //
    protected $primaryKey = 'att_id';
    protected $table = 'attendance';

    public function getAttendance()
    {
    		$this->data       =    DB::table('attendance')

            // if(Auth::user()->accesslvl_id != 1)
            // {
            //     $data   =    $data->where('emp_id',Auth::user()->id);
            //     //check userlevel
            // }
            
            
            ->leftJoin('users', 'attendance.emp_id', '=', 'users.id')
            ->leftJoin('status','attendance.status_id','=','status.stat_id')
            ->select(array('users.*', 'attendance.*','status.stat_name'))
            ->where('emp_id',Auth::user()->id)->where('date', '=', Carbon::now()->format('Y-m-d'))
            ->orderBy('att_id','desc')
            ->get();
            // $data       =    $data->paginate(200); //record per page *************paginate wont work
  
            return $this->data;
            
    }

    public function getTimeIn($id,$latest)
    {
            $data       =   DB::table('attendance')->select(array('time_in'))->where('emp_id',$id)->where('att_id',$latest)->first(); 
            return $data;
    }

    public function getTimeOut($id,$latest)
    {
            $data       =   DB::table('attendance')->select(array('time_out'))->where('emp_id',$id)->where('att_id',$latest)->first();
            return $data;
    }
    public function getRequiredTimeIn($id)
    {
            $data       =   DB::table('users')
                            ->leftJoin('schedule','users.sched_id','=','schedule.id')
                            ->select(array('schedule.time_in'))
                            ->where('users.id','=',$id);
           // $data=DB::table('users')->select('req_time_in')->where('id',$id)->get();
            return $data->first();
    }
        public function getOBRequiredTimeIn($OBatt_emp_id)
    {
            $data       =   DB::table('users')
                            ->leftJoin('schedule','users.sched_id','=','schedule.id')
                            ->select(array('schedule.time_in'))
                            ->where('users.id','=',$OBatt_emp_id);
           // $data=DB::table('users')->select('req_time_in')->where('id',$id)->get();
            return $data->first();
    }
    public function getRequiredTimeOut($id)
    {
        $data           =   DB::table('users')
                            ->leftJoin('schedule','users.sched_id','=','schedule.id')
                            ->select(array('schedule.time_out'))
                            ->where('users.id','=',$id);
        return $data->first();
    }

    public function getUserHistory($id)
    {
            $data       =   DB::table('attendance')
                            ->leftJoin('users','attendance.emp_id','=','users.id')
                            ->leftJoin('status','attendance.status_id','=','status.stat_id')
                            ->leftJoin('position','users.position_id','=','position.id')
                            ->leftJoin('department','users.dep_id','=','department.dep_id')
                            ->select(array('users.*', 'attendance.*','status.*','position.*','department.*'))
                            ->where('emp_id',$id)
                            ->orderBy('att_id','desc')
                            ->get();
            return $data;
    }

    public function getallRecord()
    {
            $data       =   DB::table('attendance')
                            ->leftJoin('users','attendance.emp_id','=','users.id')
                            ->leftJoin('status','attendance.status_id','=','status.stat_id')
                            ->select((array('users.fname','users.mname','users.sname','attendance.*','status.*')))
                            ->orderBy('att_id','desc')
                            ->get();
            return $data;
    }
    public function getLatestatt_id()
    {

            $data       =   DB::table('attendance')
                            ->where('emp_id', '=', Auth::user()->id)
                            ->where('date', '=', Carbon::now()->format('Y-m-d'));
                   // ->first();
            return $data->first();
    }
    // check if user has pending request
    public function getPendingItem()
    {

            $data       =   DB::table('attendance')
                            ->where('emp_id', '=', Auth::user()->id)
                            ->where('date', '=', Carbon::now()->format('Y-m-d'))
                            ->where('status_id', '=', '7');
                   // ->first();

            return $data->first();


    }
    public function check_attendance()
    {
                    $data       =   DB::table('attendance')
                            ->where('emp_id', '=', Auth::user()->id)
                            ->where('date', '=', Carbon::now()->format('Y-m-d'));
  


            return $data->first();
    }
    public function getPendingItemTimeInNotNull()
    {

            $data       =   DB::table('attendance')
                            ->where('emp_id', '=', Auth::user()->id)
                            ->where('date', '=', Carbon::now()->format('Y-m-d'))
                            ->where('time_in', '!=', '00:00:00');
                   // ->first();

            return $data->first();


    }
    // end //
    // update time-in for pending request
     public function UpdateUserTimeIn($id)
    {
        $update =array('time_in' => Carbon::now());
        DB::table('attendance')->where('date', '=', Carbon::now()->format('Y-m-d'))
        ->where('emp_id', '=',$id)
        ->update($update);

         $data       =   DB::table('attendance')
                            ->where('emp_id', '=', Auth::user()->id)
                            ->orderBy('updated_at', 'DESC');
                  return $data->first();



    }
    //end
    public function extractMonth($from,$to,$status)
    {

            $data           =   DB::table('attendance');
            $data           =   $data->leftJoin('users','attendance.emp_id','=','users.id');
            $data           =   $data->leftJoin('status','attendance.status_id','=','status.stat_id');
        if($status > 0)
        {
            $data           =   $data->where('attendance.status_id','=',$status);
        }

            $data           =   $data->whereBetween('date',[$from,$to]);
            $data           =   $data->orderBy('att_id','desc')->get();

        // $data           =   DB::table('attendance')
        //                     ->leftJoin('users','attendance.emp_id','=','users.id')
        //                     ->leftJoin('status','attendance.status_id','=','status.stat_id')

        //                     ->whereBetween('date',[$from,$to])
        //                     ->orderBy('att_id','desc')
        //                     ->get();
        // die(var_dump($data));
        return $data;
    }

    ///////////////////////////
    public function extractIndividual($id = 0, $from, $to, $status = 0)
    {    
        $data           =   DB::table('attendance');
        $data           =   $data->leftJoin('users','attendance.emp_id','=','users.id');
        $data           =   $data->leftJoin('status','attendance.status_id','=','status.stat_id');
    if($status > 0)
    {
        $data           =   $data->where('attendance.status_id','=',$status);
    }
        $data           =   $data->where('users.id','=',$id);
        $data           =   $data->whereBetween('date',[$from,$to]);
        $data           =   $data->orderBy('att_id','desc');
        $data           =   $data->get();

        return $data;
    }
    public function whosIn()
    {
        $data           =   DB::table('attendance')
                            ->leftJoin('users','attendance.emp_id','=','users.id')
                            ->leftJoin('status','attendance.status_id','=','status.stat_id')
                            ->where('attendance.date',Carbon::now()->format('Y-m-d'))
                            ->get();

        return $data;
    }
    public function filterbyStatus($status)//$choice
    {
        $data           =   DB::table('attendance')
                            ->leftJoin('users','attendance.emp_id','=','users.id')
                            ->leftJoin('status','attendance.status_id','=','status.stat_id')
                            ->where('attendance.status_id','=',$status)
                            ->orderBy('att_id','desc')
                            ->get();
        return $data;
    }
    public function allStatus()
    {
        $data           =   DB::table('attendance')
                            ->leftJoin('users','attendance.emp_id','=','users.id')
                            ->leftJoin('status','attendance.status_id','=','status.stat_id')
                            ->get();
        return $data;
    }
    public function manualAdd($id, $time_in, $time_out)
    {
        DB::table('attendance')
        ->insert([
                'emp_id'=>$id,
                'time_in'=>$time_in,
                'time_out'=>$time_out,
                'date'=>Carbon::today()
                ]);  
    }
    public function countMinsLate($id)
    {
        $data           =   DB::table('attendance')
                            ->where('emp_id',$id)
                            ->sum('mins_late');
        return $data;
    }
    public function countMinsLateFilter($id, $from, $to)
    {
        $data           =   DB::table('attendance')
                            ->where('emp_id',$id)
                            ->whereBetween('date',[$from,$to])
                            ->sum('mins_late');
        return $data;
    }
    public function countHrsRendered($id)
    {
        $data           =   DB::table('attendance')
                            ->where('emp_id',$id)
                            ->sum('hrs_rendered');
        return $data;
    }
    public function countHrsRenderedFilter($id, $from, $to)
    {
        $data           =   DB::table('attendance')
                            ->where('emp_id', $id)
                            ->whereBetween('date',[$from,$to])
                            ->sum('hrs_rendered');
        return $data;
    }
     public function countUnderTime($id)
    {
        $data           =   DB::table('attendance')
                            ->where('emp_id',$id)
                            ->sum('under_time');
        return $data;
    }
    public function countMinsUnderTimeFilter($id, $from, $to)
    {
        $data           =   DB::table('attendance')
                            ->where('emp_id',$id)
                            ->whereBetween('date',[$from,$to])
                            ->sum('under_time');
        return $data;
    }
    public function OBout($empid,$OBouts,$OBin,$OBDate,$OBfname,$Osname)
    {

        DB::table('request_status')
        ->insert([
                'emp_id'=>$empid,
                'fname'=>$OBfname,
                'sname'=>$Osname,
                'Request_In'=>$OBin,
                'Request_Out'=>$OBouts,
                'Date'=>$OBDate,
                'att_id'=>0,
                'Request_Status'=>'Pending'
                ]);
    }
    public function getOBAttendance($id){
        $data       =    DB::table('request_status');
            if(Auth::user()->accesslvl_id != 1)
            {
           
          $data   =    $data->where('emp_id','=',$id)->orderBy('Date','desc');
       
            }else{

            $data   =    $data->orderBy('Date','desc');

            }

          
    $data       =    $data->paginate(10);
            return $data;
// return $id;

    }



 
    public function ObNewAttendance($OBatt_emp_id,$ObRequestDate,$ObRequestIn,$ObRequestOut,$ObRequestID){
       $data = DB::table('attendance')
        ->insert([
                'emp_id'=>$OBatt_emp_id,
                'time_in'=>$ObRequestIn,
                'time_out'=>$ObRequestOut,
                'date'=>$ObRequestDate,
                'Log_Mode_Id'=>2,
                'Request_Status_ID'=>$ObRequestID
                ]);  
      
    }
    public function UpdateRequest($attID,$ObRequestID){

        $update = array('Request_Status' => 'Granted','att_id'=>$attID);
        DB::table('request_status')->where('id','=',$ObRequestID)
        ->update($update);
    }
    // public function CountHrsRender($ids,$computed_hrs)
    // {
    //     $update =array('time_out' => $computed_hrs);
    //     DB::table('attendance')->where('emp_id','=',$ids)->where('date','=',carbon::now()->format('Y-m-d'))->update($update);
    //     return 'dasdasd';
    // }
    #########################################
    # Dummy methods
    #########################################

    // public function updateTimeOut($table = '', $idCol = '', $id = 0, $field_values = array())
    // {
    //     DB::table($table)->where($idCol, '=', $id)->update($field_values);
    // }
public function newattendance($empID){

    $update = array('time_in' => Carbon::now());
    DB::table('attendance')->where('date',Carbon::today()->format('Y-m-d'))->where('emp_id',$empID)->update($update);
}
public function getObInOut($empID,$OBDate){
    $data = DB::table('request_status')->where('Date', $OBDate)->where('emp_id',$empID)->where('att_id','0')->first();
    
    return $data;
}
public function getObInOut2($empID){
    $data = DB::table('request_status')->where('emp_id',$empID)->where('att_id','0')->first();
    
    return $data;
}
  public function retrieveAttendance($id)
    {
        $data = DB::table('attendance')
                ->select('attendance.*')
                ->where('emp_id','=',$id)
                ->get();
                //->paginate(5);

        return $data;
    }
    public function UpdateRequestDeny($OB_emp_id){

       $ObRequest=DB::table('request_status')->where('emp_id','=',$OB_emp_id)->where('Request_Status','=','Pending')->first();
       $ObRequestID = $ObRequest->id;
       $ObRequestDate = $ObRequest->Date;

        $update = array('Request_Status' => 'Denied');
        DB::table('request_status')->where('id','=',$ObRequestID)->where('Date',$ObRequestDate)
        ->update($update);

        
    }
}
