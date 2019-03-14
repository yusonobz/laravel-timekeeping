<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class addUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
 public function rules()
    {
        return [
            //
            'email' => 'required',
            'password' => 'required',
            'fname' =>'required',
            'mname' =>'required',
            'sname' =>'required',
            'start_of_employment' =>'required'
        ];
    }
}
