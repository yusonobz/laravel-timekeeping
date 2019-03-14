<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Attendance;
use App\User;
use App\Users;
use PDF;
use Auth;
use Response;
use Carbon\Carbon;
class reportGenerationController extends Controller
{   
 
    //
    var $data = array();

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
    	$report_att                = new Attendance;
    	$this->data['attendance']  = $report_att->getallRecord();
    	return view('page.reportGeneration',$this->data);
    }
    
    public function printReport(Request $request)
    {
        $from                       = $request['from_date'];
        $to                         = $request['to_date'];
        $status                     = $request['sched_id'];
        $tryxtract                  = new Attendance;
        $this->data['attendance']   = $tryxtract->extractMonth($from,$to,$status); //////
        $pdf                        = PDF::loadView('page.reports',$this->data);
        return $pdf->download('Attendance Report.pdf');

  //       $report_att = new Attendance;
  //       $this->data['attendance'] = $report_att->getallRecord();
  //   	$pdf = PDF::loadView('page.reports',$this->data);
		// return $pdf->download('sample.pdf');
    }

    public function tryextract(Request $request)
    {
        $from                           = $request['from'];
        $to                             = $request['to'];
        $status                         = $request['sched_id'];
        $tryxtract                      = new Attendance;
        $this->data['old_fr']           = $from;
        $this->data['old_to']           = $to;
        $this->data['attendance']       = $tryxtract->extractMonth($from,$to,$status);
        //var_dump($this->data);die;
      
        return view('page.reportGeneration',$this->data);
    }

    public function individualExtract(Request $request)
    {
        $from                           = $request['from'];
        $to                             = $request['to'];
        $id                             = $request['emp_id'];
        $status                         = $request['sched_id'];//
        $this->data['user']             = Users::find($id);
        $this->data['id']               = $id;
        $extractAttendance              = new Attendance;
        $this->data['countMins']        = $extractAttendance->countMinsLateFilter($id, $from, $to);
        $this->data['countHrs']         = $extractAttendance->countHrsRenderedFilter($id, $from, $to);
        $this->data['attendance']       = $extractAttendance->extractIndividual($id, $from, $to, $status);
        $this->data['countUnderTime']   = $extractAttendance->countMinsUnderTimeFilter($id, $from, $to);

       return view('page.employeeRecord',$this->data);
        //var_dump($this->data['attendance']);die;
    }
    public function historyFilter(Request $request)
    {
        $from                           = $request['from'];
        $to                             = $request['to'];
        $id                             = Auth::user()->id;
        $myHistory                      = new Attendance;
        $this->data['attendance']       = $myHistory->extractIndividual($id, $from, $to);

        return view('page.recordHistory',$this->data);
    }
    public function filterbyStatus(Request $request)
    {
      $status                           = $request['sched_id'];
      $filterStatus                     = new Attendance;
      if($status == 0)
      {
        $this->data['attendance']       = $filterStatus->allStatus();
        return view('page.reportGeneration',$this->data);die;
      }
      else
      {
        $this->data['attendance']        = $filterStatus->filterbyStatus($status);
      // var_dump($this->data);
      return view('page.reportGeneration',$this->data);
      }
    }

    ###############
    ###  excel  ###
    #   export    #
    #             #
    ###############
    public function exportContacts(Request $request)
    {

      
        $csv_fields = array('Name', 'Date', 'Time in', 'Remarks', 'Time out', 'Minutes Late', 'Hours Rendered');
        $from                                   = $request['from_date'];
        $to                                     = $request['to_date'];
        $status                                 = $request['sched_id'];
        // Set the source of rows for the CSV
        $this->attendance                       = new Attendance;
        $this->data['attendance']               = $this->attendance->extractMonth($from,$to,$status);
        // echo '<pre>';
        // die(var_dump($this->data['attendance']));
        // Set the file properties
        //$this->data['csv']['name']         = (Input::get('file_name') ? Input::get('file_name') : date('Y-m-d-H-i-s')).'.csv';
        $this->data['csv']['name']              = 'Attendance.csv';
        $this->data['csv']['handle']            = fopen($this->data['csv']['name'], 'w+');
        // Set the column headers 
        // 
        fputcsv($this->data['csv']['handle'],$csv_fields);
        // Set the value for each rows
        foreach ($this->data['attendance'] as $att) {
            // Map the row values to their respective column
            $this->data['csv']['tmp']   = array (
                                                    $att->fname.' '.$att->mname.' '.$att->sname,
                                                    Carbon::parse($att->date)->format('M d, Y'),
                                                    Carbon::parse($att->time_in)->format('h:i:s A'),
                                                    $att->stat_name,
                                                    Carbon::parse($att->time_out)->format('h:i:s A'),
                                                    $att->mins_late . ' minute(s)',
                                                    $att->hrs_rendered . ' hour(s)'
                                                );
            // Add array as new row in the CSV
            fputcsv($this->data['csv']['handle'], $this->data['csv']['tmp']);
            // Unset the array to be available as new row
            unset ($this->data['csv']['tmp']);
        }
        // Set file type
        $this->data['csv']['headers']   = array(
                                                    'Content-Type' => 'text/csv',
                                                );
        ob_end_clean();
       // die(var_dump($this->data['csv']['handle']));
        return Response::download($this->data['csv']['name'], 'Attendance.csv', $this->data['csv']['headers']);
    }












    ##############################notincluded

    //  public function exportContacts()
    // {
    //     // Set the source of rows for the CSV
    //     $this->contact                  = new Contacts;
    //     $this->data['contacts']         = $this->contact->getContactByGroupExport((Input::get('group_id') > 0 ? Input::get('group_id') : 0));
    //     // Set the file properties
    //     $this->data['csv']['name']      = (Input::get('file_name') ? Input::get('file_name') : date('Y-m-d-H-i-s')).'.csv';
    //     $this->data['csv']['handle']    = fopen($this->data['csv']['name'], 'w+');
    //     // Set the column headers
    //     fputcsv($this->data['csv']['handle'], config('constants.csv_fields'));
    //     // Set the value for each rows
    //     foreach ($this->data['contacts'] as $contact) {
    //         // Map the row values to their respective column
    //         $this->data['csv']['tmp']   = array (
    //                                                 $contact->email,
    //                                                 $contact->fname,
    //                                                 $contact->lname,
    //                                                 $contact->contact,
    //                                                 $contact->gender,
    //                                                 $contact->address,
    //                                                 $contact->city,
    //                                                 $contact->province,
    //                                                 $contact->zip,
    //                                                 $contact->birth_date,
    //                                                 ($contact->status == 'A' ? 'Active' : 'Unsubscribed')
    //                                             );
    //         // Add array as new row in the CSV
    //         fputcsv($this->data['csv']['handle'], $this->data['csv']['tmp']);
    //         // Unset the array to be available as new row
    //         unset ($this->data['csv']['tmp']);
    //     }
    //     // Set file type
    //     $this->data['csv']['headers']   = array(
    //                                                 'Content-Type' => 'text/csv',
    //                                             );
    //     return Response::download($this->data['csv']['name'], (Input::get('file_name') ? Input::get('file_name') : date('Y-m-d-H-i-s')).'.csv', $this->data['csv']['headers']);
    // }



}
