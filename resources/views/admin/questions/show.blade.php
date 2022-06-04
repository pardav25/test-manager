@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.question.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.questions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.id') }}
                        </th>
                        <td>
                            {{ $question->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.title') }}
                        </th>
                        <td>
                            {{ $question->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.text') }}
                        </th>
                        <td>
                            {!! $question->text !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.subject') }}
                        </th>
                        <td>
                            {{ $question->subject->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.question.fields.type') }}
                        </th>
                        <td>
                            {{ $question->type->type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.questions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#question_answers" role="tab" data-toggle="tab">
                {{ trans('cruds.answer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="question_answers">
            @includeIf('admin.questions.relationships.questionAnswers', ['answers' => $question->questionAnswers])
        </div>
    </div>
</div>

@endsection