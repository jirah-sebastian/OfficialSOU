<?php

namespace App\Http\Requests;

use App\Models\SoRegistration;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySoRegistrationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('so_registration_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:so_registrations,id',
        ];
    }
}
