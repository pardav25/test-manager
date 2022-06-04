<?php

namespace App\Http\Requests;

use App\Models\Question;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('question_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'min:2',
                'required',
            ],
            'text' => [
                'required',
            ],
            'subject_id' => [
                'required',
                'integer',
            ],
            'type_id' => [
                'required',
                'integer',
            ],
        ];
    }
}