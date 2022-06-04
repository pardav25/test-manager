@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.type.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.type.fields.id') }}
                        </th>
                        <td>
                            {{ $type->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.type.fields.type') }}
                        </th>
                        <td>
                            {{ $type->type }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.types.index') }}">
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
            <a class="nav-link" href="#type_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.question.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#type_answers" role="tab" data-toggle="tab">
                {{ trans('cruds.answer.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="type_questions">
            @includeIf('admin.types.relationships.typeQuestions', ['questions' => $type->typeQuestions])
        </div>
        <div class="tab-pane" role="tabpanel" id="type_answers">
            @includeIf('admin.types.relationships.typeAnswers', ['answers' => $type->typeAnswers])
        </div>
    </div>
</div>

@endsection