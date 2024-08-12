<?php

namespace App\Http\Requests;

use App\Models\SoRegistration;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSoRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('so_registration_edit');
    }

    public function rules()
    {
        return [
            'full_name' => [
                'string',
                'nullable',
            ],
            'email' =>[
                'email',
                'required',
                // 'regex:/(.*)clsu2\.edu\.ph$/i',
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
            'mother_contact_no' => [
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
            'position' => [
                'string',
                'nullable',
            ],
            'remarks' => [
                'string',
                'nullable',
            ],

        ];
    }
}
