@extends('admin.partials.layout')

@php
    $add = empty($recommendation);
    $title = $add ? 'Add Recommendation' : 'Edit Recommendation';
    $url = $add ? route('admin.recommendations.store') : route('admin.recommendations.update', $recommendation['id']);
@endphp

@section('title', $title)

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Recommendations</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @include('admin.partials.messages')
            <div class="row">
                <!-- left column -->
                <div class="col-12">
                    <!-- general form elements -->
                    <div class="card">
                        <!-- form start -->
                        <form action="{{ $url }}" enctype="multipart/form-data" method="POST">
                            @if (!$add)
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="user">Brand/Creator Name</label>
                                    <select id="user" name="user" class="form-control @error('user') is-invalid @enderror"
                                            @if ($add) required @else readonly @endif>
                                        @foreach ($users as $user)
                                            @if ($add)
                                                <option value="{{ $user['id'] }}" data-type="{{ $user['type'] }}"
                                                        @if (old('user') == $user['id']) selected @endif>
                                                    {{ $user['name'] }}
                                                </option>
                                            @elseif ($recommendation['user_id'] == $user['id'])
                                                <option value="{{ $user['id'] }}">
                                                    {{ $user['name'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('user')
                                        <label for="user" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="recommendation">Recommendation</label>
                                    <select id="recommendation" name="recommendation" class="form-control @error('recommendation') is-invalid @enderror"
                                            @if ($add) required @else readonly @endif>
                                        @foreach ($users as $user)
                                            @if ($add)
                                                <option value="{{ $user['id'] }}" data-email="{{ $user['email'] }}" data-type="{{ $user['type'] }}"
                                                        @if (old('recommendation') == $user['id']) selected @endif>
                                                    {{ $user['name'] }}
                                                </option>
                                            @elseif ($recommendation['recommendation_user_id'] == $user['id'])
                                                <option value="{{ $user['id'] }}">
                                                    {{ $user['name'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('recommendation')
                                        <label for="recommendation" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', !$add ? $recommendation['email'] : '') }}"
                                           placeholder="Enter email" required>
                                    @error('email')
                                        <label for="email" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="note">Note</label>
                                    <input type="text" id="note" name="note"
                                           class="form-control @error('note') is-invalid @enderror"
                                           value="{{ old('note', !$add ? $recommendation['note'] : '') }}"
                                           placeholder="Enter note" required>
                                    @error('note')
                                        <label for="note" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="response_time">Response Time</label>
                                    <select id="response_time" name="response_time" class="form-control @error('response_time') is-invalid @enderror" required>
                                        @php $old_response_time = old('response_time', !$add ? $recommendation['response_time'] : '') @endphp
                                        <option value="1" @if ($old_response_time == 1) selected @endif>1 Hour</option>
                                        <option value="2" @if ($old_response_time == 2) selected @endif>1 Day</option>
                                        <option value="3" @if ($old_response_time == 3) selected @endif>1 Week</option>
                                        <option value="4" @if ($old_response_time == 4) selected @endif>1 Month</option>
                                    </select>
                                    @error('response_time')
                                        <label for="response_time" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.recommendations.index') }}" class="btn btn-danger ml-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            @if ($add)
                changeUser()
            @endif

            $('#user').on('change', changeUser)

            $('#recommendation').on('change', changeRecommendation)
        })

        function changeUser() {
            const type = $('#user').find('option:selected').data('type')
            $('#recommendation option').show()
            $('#recommendation option[data-type="' + type + '"]').hide()
            $('#recommendation').val($('#recommendation option:not([data-type="' + type + '"])').attr('value'))
            changeRecommendation()
        }

        function changeRecommendation() {
            $('#email').val($('#recommendation').find('option:selected').data('email'))
        }
    </script>
@endsection
