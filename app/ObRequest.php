<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
class ObRequest extends Model
{
        protected $primaryKey = 'id';
    protected $table = 'request_status';
}
