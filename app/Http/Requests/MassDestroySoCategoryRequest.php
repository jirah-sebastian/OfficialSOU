<?php

namespace App\Http\Requests;

use App\Models\SoCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySoCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('so_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:so_categories,id',
        ];
    }
}
