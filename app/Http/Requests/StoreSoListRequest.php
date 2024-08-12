<?php

namespace App\Http\Requests;

use App\Models\SoList;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSoListRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('so_list_create');
    }

    public function rules()
    {
        return [
            'so_name' => [
                'string',
                'nullable',
            ],
            'organization_admins.*' => [
                'integer',
            ],
            'organization_admins' => [
                'array',
            ],
            'overview' => [
                'string',
                'nullable',
                'required', 
            ],
            'information' => [
                'required', 
            ],

            'banner' => [
                'required',           
            ],
            'remark' => [
                'string',
                'nullable',
            ],
            'anniversary_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}