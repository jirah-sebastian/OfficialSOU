<?php

namespace App\Http\Requests;

use App\Models\SoList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSoListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('so_list_edit');
    }

    public function rules()
    {
        return [
            'so_name' => [
                'string',
                'required',
            ],
            'organization_admins.*' => [
                'integer',
                'required',
            ],
            'organization_admins' => [
                'array',
                // 'required',
            ],
            'overview' => [
                'string',
                'required',
            ],
            'information' => [
                'required',
            ],
           
            'remark' => [
                'string',
                'nullable',
            ],
            'anniversary_date' => [
                'date_format:' . config('panel.date_format'),
                'required',
            ],
        ];
    }
}