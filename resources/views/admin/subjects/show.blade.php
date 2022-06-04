@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.subject.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subjects.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.id') }}
                        </th>
                        <td>
                            {{ $subject->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.name') }}
                        </th>
                        <td>
                            {{ $subject->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.subject.fields.description') }}
                        </th>
                        <td>
                            {!! $subject->description !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.subjects.index') }}">
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
            <a class="nav-link" href="#subject_questions" role="tab" data-toggle="tab">
                {{ trans('cruds.question.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#subject_tests" role="tab" data-toggle="tab">
                {{ trans('cruds.test.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#subjects_users" role="tab" data-toggle="tab">
                {{ trans('cruds.user.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="subject_questions">
            @includeIf('admin.subjects.relationships.subjectQuestions', ['questions' => $subject->subjectQuestions])
        </div>
        <div class="tab-pane" role="tabpanel" id="subject_tests">
            @includeIf('admin.subjects.relationships.subjectTests', ['tests' => $subject->subjectTests])
        </div>
        <div class="tab-pane" role="tabpanel" id="subjects_users">
            @includeIf('admin.subjects.relationships.subjectsUsers', ['users' => $subject->subjectsUsers])
        </div>
    </div>
</div>

@endsection