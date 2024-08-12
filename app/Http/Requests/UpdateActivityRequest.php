<?php

namespace App\Http\Requests;

use App\Models\Activity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateActivityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('activity_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'sub_title' => [
                'string',
                'required',
            ],
            'event_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'required',
            ],
            'sustainable_development_goal' => [
                'required',
                'array',
            ],
            'sustainable_development_goal.*' => [
                'string',
            ],
            'event_place' => [
                'string',
                'required',
            ],
            'content' => [
                'required',
            ],
            // 'content-photo' => [
            //     'required',
            // ],
            // 'permit' => [
            //     'required',
            // ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }

}
