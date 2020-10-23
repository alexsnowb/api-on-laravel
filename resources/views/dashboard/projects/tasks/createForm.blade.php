                <div class="card">
                    <div class="card-header">
                      <i class="fa fa-align-justify"></i> {{ __('Create Task') }}</div>
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
                        <form method="POST" action="{{ url('/projects/'.$project->id.'/tasks/') }}">
                            @csrf
                            <div class="form-group row">
                                <label>{{ __('Name') }}</label>
                                <input class="form-control" type="text" placeholder="{{ __('Name') }}" name="name" required autofocus>
                            </div>

                            <div class="form-group row">
                                <label>{{ __('Description') }}</label>
                                <textarea class="form-control" id="textarea-input" name="description" rows="3" placeholder="{{ __('Description') }}" required></textarea>
                            </div>

                            <div class="form-group row">
                                <label>{{ __('Url') }}</label>
                                <input class="form-control" type="text" placeholder="{{ __('Url') }}" name="url" required autofocus>
                            </div>

                            <div class="form-group row">
                                <label>{{ __('Method') }}</label>
                                <select class="form-control" name="method">
                                    @foreach(App\Models\Task::methodList() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row">
                                <label>{{ __('Body') }}</label>
                                <textarea class="form-control" id="textarea-input" name="body" rows="3" placeholder="{{ __('Body') }}"></textarea>
                            </div>

                            <div class="form-group row">
                                <label>{{ __('Period') }}</label>
                                <select class="form-control" name="period">
                                    @foreach(App\Models\Task::periodList() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button class="btn btn-block btn-success" type="submit">{{ __('Add') }}</button>
                            <a href="{{ route('projects.index') }}" class="btn btn-block btn-primary">{{ __('Return') }}</a>
                        </form>
                    </div>
                </div>
