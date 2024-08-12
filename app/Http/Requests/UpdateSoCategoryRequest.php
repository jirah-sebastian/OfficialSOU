<?php

namespace App\Http\Requests;

use App\Models\SoCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSoCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('so_category_edit');
    }

    public function rules()
    {
        return [
            'category_name' => [
                'string',
                'required',
            ],
        ];
    }
}
