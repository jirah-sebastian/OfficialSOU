<?php

namespace App\Http\Requests;

use App\Models\OrganizationApplicationForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOrganizationApplicationFormRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('organization_application_form_create');
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
