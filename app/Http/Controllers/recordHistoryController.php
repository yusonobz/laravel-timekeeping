<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class recordHistoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }  
    public function index($id)
    {
        $user                     = new Attendance;
        $this->data['attendance'] = $user->getUserHistory($id);

       return view('page.recordHistory',$this->data);

// return $this->data['ViewLevel'];
    }
}
