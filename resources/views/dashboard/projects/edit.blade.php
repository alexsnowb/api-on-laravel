@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{ __('Edit') }}: {{ $project->name }}</div>
                    <div class="card-body">
                        <form method="POST" action="/projects/{{ $project->id }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <div class="col">
                                    <label>{{ __('Name') }}</label>
                                    <input class="form-control" type="text" placeholder="{{ __('Name') }}" name="name" value="{{ $project->name }}" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label>{{ __('Description') }}</label>
                                    <textarea class="form-control" id="textarea-input" name="content" rows="9" placeholder="{{ __('Description') }}" required>{{ $project->description }}</textarea>
                                </div>
                            </div>

                            <button class="btn btn-block btn-success" type="submit">{{ __('Save') }}</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-block btn-primary">{{ __('Return') }}</a>
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
