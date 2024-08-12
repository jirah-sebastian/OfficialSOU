<?php

namespace App\Http\Requests;

use App\Models\User;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('user_create');
    }

    public function rules()
    {
        return [

            'profile' => [
                'required', 
            ],

            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users',
                'email',
                'regex:/(.*)clsu2\.edu\.ph$/i',
            ],
            'password' => [
                'required',
            ],
            'roles.*' => [
                'integer',
            ],
            'roles' => [
                'required',
                'array',
            ],
            'course' => [
                'string',
                'nullable',
            ],
            'religion' => [
                'string',
                'nullable',
            ],
            'nationality' => [
                'string',
                'nullable',
            ],
            'birthdate' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'birthplace' => [
                'string',
                'nullable',
            ],
            'present_address' => [
                'string',
                'nullable',
            ],
            'home_address' => [
                'string',
                'nullable',
            ],
            'contact_no' => [
                'string',
                'nullable',
            ],
            'father_name' => [
                'string',
                'nullable',
            ],
            'father_contact_no' => [
                'string',
                'nullable',
            ],
            'mother_name' => [
                'string',
                'nullable',
            ],
            'mothers_contact_no' => [
                'string',
                'nullable',
            ],
            'source_of_financial_support' => [
                'string',
                'nullable',
            ],
            'talent_skills' => [
                'string',
                'nullable',
            ],
            'date_filed' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'gender' => [
                'string',
                'nullable',
            ],

            'gender' => [
                'string',
                'nullable',
            ],

            'remark' => [
                'string',
                'nullable', 
            ],
        ];
    }
}
