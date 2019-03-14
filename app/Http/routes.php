<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//<a href="{{ url('/main') }}">



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
		Route::get('/', 'loginController@index');
		Route::get('/employeeRecord/{id}','employeeRecordController@index');////////////
		Route::get('/CH', 'CHController@index');
		Route::get('/employeeView', 'employeeViewController@index');
		Route::get('/purpleBugTK', 'purpleBugTKController@index');//admin dashboard
		Route::get('/recordM', 'recordMController@index');
		Route::get('/timeKeeping', 'timeKeepingController@index');
		Route::get('/user','normalUserController@index');//normaluser dashboard
		Route::get('/history/{id}','recordHistoryController@index');
		Route::get('/generateReport','reportGenerationController@index');
		Route::get('/reportModule','reportModuleController@index');

		Route::get('/getDate','loginController@getStatus');//why
		Route::get('/logout','loginController@logout');
		Route::get('/delete-employee/{id}','recordMController@delete');
		Route::get('/add-attendance','purpleBugTKController@timein');//for time-in


		Route::get('/obrequestlist','purpleBugTKController@OBRequestList');//OB Request List
		Route::PATCH('/purpleBugTK','purpleBugTKController@obtimein');//for OB
        Route::PATCH('/user','purpleBugTKController@obtimein');
        Route::get('/ObRequest/Grant/{id}','purpleBugTKController@obgrant');
        Route::get('/ObRequest/Deny/{id}','purpleBugTKController@deny');
        Route::get('/download/{id}','CHController@downloadPDF');
        Route::get('/timeKeeping/Activate/{id}','timeKeepingController@activate');
        Route::get('/timeKeeping/Deactivate/{id}','timeKeepingController@deactivate');
		Route::post('purpleBugTK/upload', 'CHController@upload');

		Route::get('/add-timeout/{id}','purpleBugTKController@timeout');// for timeout
		Route::post('/add-employee', 'recordMController@store');
		Route::post('/loguserin', 'loginController@loguserin');
		Route::get('/login', 'loginController@index');
		Route::get('/edit-emp-info','recordMController@edit');

		Route::get('/timecheck','purpleBugTKController@timecheck');
		Route::get('/trydiff/{id}','purpleBugTKController@diff');
		Route::get('/required_time_in/{id}','purpleBugTKController@checktimein');
		//nextroute - edit


		Route::post('/extract','reportGenerationController@tryextract');
		Route::post('/individualExtract','reportGenerationController@individualExtract');
		Route::get('/whosin','purpleBugTKController@whosIn');
		Route::post('/filterbyStatus','reportGenerationController@filterbyStatus');
		Route::post('/filterHistory','reportGenerationController@historyFilter');
		Route::post('/manualAttendance','employeeRecordController@manualTimein');
		Route::post('/changePass/{id}','recordMController@changePassword');
		Route::post('/changePassword','recordMController@authChangepassword');
		Route::get('/editEmployee/{id}', 'recordMController@updatepage');//edit Employee
		Route::post('/modifyEmployee','recordMController@editEmployee');
		Route::get('/dl','reportGenerationController@exportContacts');
		Route::get('/gets/{id}','purpleBugTKController@undertimeTry');
		Route::get('/user','normalUserController@index');
		Route::get('/ob-store','normalUserController@obStore');
		// Route::post('/ob-store','normalUserController@obStore');
		// Route::post('/individualextract/{id}','employeeRecordController@individualtryextract');
		//Route::get('/getcount','employeeRecordController@getCount');

});
?>	
