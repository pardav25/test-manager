@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.question.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.questions.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.question.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('title', '') }}" required>
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.question.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="text">{{ trans('cruds.question.fields.text') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('text') ? 'is-invalid' : '' }}" name="text"
                        id="text">{!! old('text') !!}</textarea>
                    @if ($errors->has('text'))
                        <div class="invalid-feedback">
                            {{ $errors->first('text') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.question.fields.text_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="subject_id">{{ trans('cruds.question.fields.subject') }}</label>
                    <select class="form-control select2 {{ $errors->has('subject') ? 'is-invalid' : '' }}"
                        name="subject_id" id="subject_id" required>
                        @foreach ($subjects as $id => $entry)
                            <option value="{{ $id }}" {{ old('subject_id') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('subject'))
                        <div class="invalid-feedback">
                            {{ $errors->first('subject') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.question.fields.subject_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="type_id">{{ trans('cruds.question.fields.type') }}</label>
                    <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id"
                        id="type_id" required>
                        @foreach ($types as $id => $entry)
                            <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>
                                {{ $entry }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('type'))
                        <div class="invalid-feedback">
                            {{ $errors->first('type') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.question.fields.type_helper') }}</span>
                </div>
                {{-- ### Start Answer Section ### --}}
                {{-- new answer --}}
                <div class="form-group">
                    <label class="required" for="newAnswer">Add Answer</label>
                    <div class="input-group mb-3">
                        <input class="form-control" type="text" name="newAnswer" id="newAnswer" value="" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-info" id="enter" type="button">Add</button>
                        </div>
                    </div>
                </div>
                {{-- list of answers for OneSelect and MultipleChoise --}}
                <div class="form-group">
                    <label class="" for="listOfAnswers">List of Answers</label>
                    <div class="col-12">
                        <ul class="list-group" id="listOfAnswers" name="listOfAnswers"></ul>
                    </div>
                </div>
                {{-- list of solution for OneSelect and MultipleChoise --}}
                <div class="form-group invisible">
                    <label class="" for="rightAnswer">Select right Answer</label>
                    <select class="form-control select2" name="rightAnswer" id="rightAnswer">
						{{-- Insert Here right answer --}}
                    </select>
                </div>
                {{-- ### End Answer Section ### --}}
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function SimpleUploadAdapter(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
                    return {
                        upload: function() {
                            return loader.file
                                .then(function(file) {
                                    return new Promise(function(resolve, reject) {
                                        // Init request
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('POST',
                                            '{{ route('admin.questions.storeCKEditorImages') }}',
                                            true);
                                        xhr.setRequestHeader('x-csrf-token', window._token);
                                        xhr.setRequestHeader('Accept', 'application/json');
                                        xhr.responseType = 'json';

                                        // Init listeners
                                        var genericErrorText =
                                            `Couldn't upload file: ${ file.name }.`;
                                        xhr.addEventListener('error', function() {
                                            reject(genericErrorText)
                                        });
                                        xhr.addEventListener('abort', function() {
                                            reject()
                                        });
                                        xhr.addEventListener('load', function() {
                                            var response = xhr.response;

                                            if (!response || xhr.status !== 201) {
                                                return reject(response && response
                                                    .message ?
                                                    `${genericErrorText}\n${xhr.status} ${response.message}` :
                                                    `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`
                                                    );
                                            }

                                            $('form').append(
                                                '<input type="hidden" name="ck-media[]" value="' +
                                                response.id + '">');

                                            resolve({
                                                default: response.url
                                            });
                                        });

                                        if (xhr.upload) {
                                            xhr.upload.addEventListener('progress', function(
                                            e) {
                                                if (e.lengthComputable) {
                                                    loader.uploadTotal = e.total;
                                                    loader.uploaded = e.loaded;
                                                }
                                            });
                                        }

                                        // Send request
                                        var data = new FormData();
                                        data.append('upload', file);
                                        data.append('crud_id', '{{ $question->id ?? 0 }}');
                                        xhr.send(data);
                                    });
                                })
                        }
                    };
                }
            }

            var allEditors = document.querySelectorAll('.ckeditor');
            for (var i = 0; i < allEditors.length; ++i) {
                ClassicEditor.create(
                    allEditors[i], {
                        extraPlugins: [SimpleUploadAdapter]
                    }
                );
            }

            var button = document.getElementById("enter");
            var input = document.getElementById("newAnswer");
            var ul = document.getElementById("listOfAnswers");
            var listCounter = 1;

            button.addEventListener("click", function() {
                if (listCounter <= 4){
                    var li = document.createElement("li");
                    var fakeInput = document.createElement("input");
                    /* settings for fake input into list */
                    fakeInput.name = "answer_" + listCounter;
                    fakeInput.value = input.value;
                    fakeInput.classList.add("col-12");
                    fakeInput.classList.add("col-12");
                    fakeInput.setAttribute("readonly", "true");
                    fakeInput.style.border = "none";
                    fakeInput.style.outline = "none";
                    // Add Bootstrap class to the list element
                    li.classList.add("list-group-item");
                    // Insert fakeinput into the list element
                    li.appendChild(fakeInput);
                    ul.appendChild(li);
                    listCounter++;
                }
                // Clear input
                input.value = "";
            })

        });
    </script>
@endsection
