<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTestRequest;
use App\Http\Requests\StoreTestRequest;
use App\Http\Requests\UpdateTestRequest;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Test;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class TestController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('test_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $tests = Test::with(['subject', 'questions', 'creator'])->get();

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        abort_if(Gate::denies('test_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subjects = Subject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questions = Question::pluck('title', 'id');

        $creators = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.tests.create', compact('creators', 'questions', 'subjects'));
    }

    public function store(StoreTestRequest $request)
    {
        $test = Test::create($request->all());
        $test->questions()->sync($request->input('questions', []));
        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $test->id]);
        }

        return redirect()->route('admin.tests.index');
    }

    public function edit(Test $test)
    {
        abort_if(Gate::denies('test_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subjects = Subject::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $questions = Question::pluck('title', 'id');

        $creators = User::pluck('email', 'id')->prepend(trans('global.pleaseSelect'), '');

        $test->load('subject', 'questions', 'creator');

        return view('admin.tests.edit', compact('creators', 'questions', 'subjects', 'test'));
    }

    public function update(UpdateTestRequest $request, Test $test)
    {
        $test->update($request->all());
        $test->questions()->sync($request->input('questions', []));

        return redirect()->route('admin.tests.index');
    }

    public function show(Test $test)
    {
        abort_if(Gate::denies('test_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test->load('subject', 'questions', 'creator');

        return view('admin.tests.show', compact('test'));
    }

    public function destroy(Test $test)
    {
        abort_if(Gate::denies('test_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $test->delete();

        return back();
    }

    public function massDestroy(MassDestroyTestRequest $request)
    {
        Test::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('test_create') && Gate::denies('test_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Test();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}