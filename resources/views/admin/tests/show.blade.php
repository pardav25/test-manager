@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.test.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.id') }}
                        </th>
                        <td>
                            {{ $test->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.title') }}
                        </th>
                        <td>
                            {{ $test->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.description') }}
                        </th>
                        <td>
                            {!! $test->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.subject') }}
                        </th>
                        <td>
                            {{ $test->subject->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.questions') }}
                        </th>
                        <td>
                            @foreach($test->questions as $key => $questions)
                                <span class="label label-info">{{ $questions->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.test.fields.creator') }}
                        </th>
                        <td>
                            {{ $test->creator->email ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection