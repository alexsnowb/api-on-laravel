@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{ __('Edit') }}: {{ $task->name }}</div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        <form method="POST" action="/projects/{{ $project->id }}/tasks/{{ $task->id }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <div class="col">
                                    <label for="taskName">{{ __('Name') }}</label>
                                    <input id="taskName" class="form-control" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ $task->name }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="taskDescription">{{ __('Description') }}</label>
                                    <textarea id="taskDescription" class="form-control" id="textarea-input" name="description" rows="9" placeholder="{{ __('Description') }}">{{ $task->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="taskUrl">{{ __('Url') }}</label>
                                    <input id="taskUrl" class="form-control" type="text" placeholder="{{ __('Url') }}" name="url" value="{{ $task->name }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="taskMethod">{{ __('Method') }}</label>
                                    <select id="taskMethod" class="form-control" name="method">
                                        @foreach(App\Models\Task::methodList() as $key => $value)
                                            @if( $key == $task->status_id )
                                                <option value="{{ $key }}" selected="true">{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="taskBody">{{ __('Body') }}</label>
                                    <textarea id="taskBody" class="form-control" id="textarea-input" name="body"  rows="3" placeholder="{{ __('Body') }}">{{ $task->body }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="taskPeriod">{{ __('Period') }}</label>
                                    <select id="taskPeriod" class="form-control" name="period">
                                        @foreach(App\Models\Task::periodList() as $key => $value)
                                            @if( $key == $task->period )
                                                <option value="{{ $key }}" selected="true">{{ $value }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button class="btn btn-block btn-success" type="submit">{{ __('Save') }}</button>
                            <a href="{{ route('projects.show', ['project' => $project]) }}" class="btn btn-block btn-primary">{{ __('Return') }}</a>
                        </form>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')

@endsection
