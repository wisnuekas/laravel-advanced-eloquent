<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MitraRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name' => 'required|max:23|alpha',
                    'email' => 'sometimes|required|email|unique:customers,email',
                    'phone_number' => 'sometimes|required|unique:customers,phone_number|digits_between:10,13',
                    'firebase_uid' => 'required|unique:customers,firebase_uid', 
                    'avatar' => 'image', 
                    'sex' => 'in:male,female', 
                    'date_of_birth' => 'date',
                    'min_fee' => 'required|numeric' ,
                    'max_fee' => 'sometimes|required|numeric|gte:min_fee',
                ];
            }
            case 'PUT': 
            {
                return [                    
                    'name' => 'sometimes|required|max:23|alpha',
                    'email' => 'sometimes|required|email|unique:customers,email',
                    'phone_number' => 'sometimes|required|unique:customers,phone_number|digits_between:10,13',
                    'firebase_uid' => 'sometimes|required|unique:customers,firebase_uid', 
                    'avatar' => 'image', 
                    'sex' => 'in:male,female', 
                    'date_of_birth' => 'date',
                    'min_fee' => 'required|numeric' ,
                    'max_fee' => 'sometimes|required|numeric|gte:min_fee',
                ];
            }
            case 'PATCH':
            {
                return [                    
                    'name' => 'sometimes|required|max:23|alpha',
                    'email' => 'sometimes|required|email|unique:customers,email',
                    'phone_number' => 'sometimes|required|unique:customers,phone_number|digits_between:10,13',
                    'firebase_uid' => 'sometimes|required|unique:customers,firebase_uid', 
                    'avatar' => 'image', 
                    'sex' => 'in:male,female', 
                    'date_of_birth' => 'date',
                    'min_fee' => 'required|numeric' ,
                    'max_fee' => 'sometimes|required|numeric|gte:min_fee',
                ];
            }
            default:break;
        }
    }
}
