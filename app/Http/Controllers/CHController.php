<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Attendance;
use PDF;
use Input;
use Validator;
use Redirect;
use Session;
class CHController extends Controller
{
        public function __construct() 
    {
        $countAttendance = new Attendance;
        $this->data['count'] = DB::table('attendance')->sum('hrs_rendered');
        //$this->data['count'] = $countAttendance->att_Summation();
    }
    public function downloadPDF($id)
    {
        $report_att = new Attendance;
        $this->data['attendance'] = $report_att->retrieveAttendance($id);
        $userhistory                    = new Attendance;    
        $this->data['attendance']       = $userhistory->getUserHistory($id);
   
        $pdf = PDF::loadView('reports',$this->data);
        return $pdf->download('attendance.pdf');    


    }

    public function upload() {
        $id = Auth::user()->id;
  // getting all of the post data
  $file = array('image' => Input::file('image'));
  // setting up rules
  $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
  // doing the validation, passing post data, rules and the messages
  $validator = Validator::make($file, $rules);
  if ($validator->fails()) {
    // send back to the page with the input data and errors
  \Session::flash('flash_message_error', 'Image file is Required');
     if(Auth::user()->accesslvl_id != 1)
        {
            return redirect('/user');die;
        }
        else
        {
            return redirect('/purpleBugTK');die;
        }  
  }
  else {
    // checking file is valid.
    if (Input::file('image')->isValid()) {
      $destinationPath = 'Images'; // upload path
      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
      $fileName = rand(11111,99999).'.'.$extension; // renameing image
      Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
$file = $destinationPath ."\\" . $fileName;
$update = array('DisplayPicture' =>  $file);
      DB::table('users')->where('id',$id)->update($update);
      // sending back with message
      Session::flash('flash_message_error', 'Upload successfully'); 

    }
    else {
      // sending back with error message.
      Session::flash('flash_message_error', 'uploaded file is not valid');

    }
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
}
