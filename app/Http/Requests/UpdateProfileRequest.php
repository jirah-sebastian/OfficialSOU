<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('profile_password_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'name'  => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'course' => ['nullable'],
            'year' => ['nullable'],
            'religion' => ['nullable'],
            'nationality' => ['nullable'],
            'birthdate' => ['nullable'],
            'birthplace' => ['nullable'],
            'gender' => ['nullable'],
            'present_address' => ['nullable'],
            'home_address' => ['nullable'],
            'contact_no' => ['nullable'],
            'father_name' => ['nullable'],
            'father_contact_no' => ['nullable'],
            'mother_name' => ['nullable'],
            'mothers_contact_no' => ['nullable'],
            'source_of_financial_support' => ['nullable'],
            'talent_skills' => ['nullable'],
            'date_filed' => ['nullable'],
            'gender' => ['nullable'],
        ];
    }
}
