<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Attendance;
# Import Facade
use DB;
use Auth;
use Input;
use \Carbon\Carbon;
use Validator;
use Redirect;
use Mail;

class normalUserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {

        $attendance                             = new Attendance;
        $this->data['attendance']               = $attendance->getAttendance();
        $this->data['current_attendance']       = DB::table('attendance')->where('emp_id', '=', Auth::user()->id)->where('date', '=', Carbon::now()->format('Y-m-d'))->first();
      //  echo $this->data['current_attendance']->att_id;
    	return view('page.normalUser', $this->data);
    }

    public function latestid()
    {
    	$attendance                    = new Attendance;
    	$this->data['attendance']      = $attendance->getLatestatt_id();
    	return $this->data;
    }
    public function obStore()
    {
       
       //  $startDate = Input::get('start-date');
       //  $startTime = Input::get('start-time');
       //  $endDate = Input::get('end-date');
       //  $endTime = Input::get('end-time');

       //  $start = $startDate .' '. $startTime;
       //  $sDate = date('Y-m-d h:i:s',strtotime($start));


       //  $newattendance                = new Attendance;
       //  $newattendance->emp_id        = Auth::user()->id;
       //  $newattendance->time_out      = $sDate;
       //  $newattendance->date          = Carbon::today();  
       //  $newattendance->status_id     = 7;  
       //  $newattendance->save();   
       
       // return redirect('/user');
        $data = array('test'=>'test');
        Mail::send('email', $data, function($message)
{
    $message->from('jeffreydanceljr@gmail.com', 'Jeffrey Dancel');

    $message->to('jeffrey.dancel@purplebug.net', 'Jeffrey Dancel');

});
    }
}
