@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> Project: {{ $project->name }}</div>
                    <div class="card-body">
                        <h4>Author:</h4>
                        <p> {{ $project->user->name }}</p>
                        <h4>Title:</h4>
                        <p> {{ $project->name }}</p>
                        <h4>Content:</h4>
                        <p>{{ $project->description }}</p>
                        <h4> Status: </h4>
                        <p>
                            <span class="{{ $project->status->class }}">
                              {{ $project->status->name }}
                            </span>
                        </p>
                        <a href="{{ route('projects.index') }}" class="btn btn-block btn-primary">{{ __('Return') }}</a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>

@endsection


@section('javascript')

@endsection
