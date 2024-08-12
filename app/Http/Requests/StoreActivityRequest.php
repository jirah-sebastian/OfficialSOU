<?php

namespace App\Http\Requests;

use App\Models\Activity;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreActivityRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('activity_create');
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
                'after_or_equal:today',
            ],
            'type_of_activity' => [
                'required',
            ],
            'gad_funded' => [
                'required',
            ],
            // 'sustainable_development_goal' => [
            //     'string',
            //     'required',
            // ],

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
            // 'permit' => [
            //     'required', 
            // ],
            'content' => [
                'required',
            ],
            // 'content_photo' => [
            //     'required', 
            // ],
            'remarks' => [
                'string',
                'nullable',
            ],
        ];
    }

    public function messages()
    {
        return [
            'event_date.after_or_equal' => 'The event date cannot be in the past.',
        ];
    }
}
