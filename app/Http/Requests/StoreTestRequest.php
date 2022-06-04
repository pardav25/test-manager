<?php

namespace App\Http\Requests;

use App\Models\Test;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('test_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'min:2',
                'required',
            ],
            'description' => [
                'required',
            ],
            'subject_id' => [
                'required',
                'integer',
            ],
            'questions.*' => [
                'integer',
            ],
            'questions' => [
                'array',
            ],
            'creator_id' => [
                'required',
                'integer',
            ],
        ];
    }
}