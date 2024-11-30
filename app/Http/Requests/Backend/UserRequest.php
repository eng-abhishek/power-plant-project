<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    		if(isset($this->user)){
    			$rules = [
    				'name' => 'required|min:5|max:30',
    				'email' => 'required|email|max:225',
    				'password' => 'max:72',
    				'role' => 'required',
    			];
    		}else{
    			$rules = [
    				'name' => 'required|min:5|max:30',
    				'email' => 'required|email|max:225|unique:users',
    				'password' => 'required|min:8|max:72',
    				'role' => 'required',
    			];
    		}
    		return $rules;
    	}
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() {
    	return [			

    	];
    }
}
