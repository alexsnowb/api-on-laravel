@extends('dashboard.base')

@section('content')

        <div class="container-fluid">
          <div class="animated fadeIn">
            <div class="row">
              <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                  @include('dashboard.projects.tasks.createForm')
              </div>
            </div>
          </div>
        </div>

@endsection

@section('javascript')

@endsection
