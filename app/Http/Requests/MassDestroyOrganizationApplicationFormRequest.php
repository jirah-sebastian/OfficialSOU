<?php

namespace App\Http\Requests;

use App\Models\OrganizationApplicationForm;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOrganizationApplicationFormRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('organization_application_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:organization_application_forms,id',
        ];
    }
}
