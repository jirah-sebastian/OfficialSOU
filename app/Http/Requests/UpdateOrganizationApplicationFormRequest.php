<?php

namespace App\Http\Requests;

use App\Models\OrganizationApplicationForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrganizationApplicationFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('organization_application_form_edit');
    }

    public function rules()
    {
        return [
            'filename' => [
                'string',
                'nullable',
            ],
        ];
    }
}
