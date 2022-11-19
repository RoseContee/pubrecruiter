@extends('admin.partials.layout')

@section('title', 'Edit Feedback')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Feedback</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Feedback</li>
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
                        <form action="{{ route('admin.feedback.update', $feedback['id']) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Website</label>
                                    <div class="form-control">{{ $feedback['domain'] }}</div>
                                </div>
                                <div class="form-group">
                                    @php
                                        $response_time = old('response_time', $feedback['response_time']) ?? 0;
                                        $text = '';
                                        switch ($response_time) {
                                            case 1: $text = '1 Hour'; break;
                                            case 2: $text = '1 Day'; break;
                                            case 3: $text = '1 Week'; break;
                                            case 4: $text = '1 Month'; break;
                                        }
                                    @endphp
                                    <label for="response_time">Response Time</label>
                                    <input type="range" id="response_time" name="response_time" class="custom-range" min="0" max="4"
                                           value="{{ $response_time }}">
                                    @error('response_time')
                                        <label for="response_time" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                    <span id="response-time-value">{{ $text }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="comment">Comment</label>
                                    <textarea id="comment" name="comment" class="form-control @error('comment') is-invalid @enderror"
                                              placeholder="Enter comment">{{ old('comment', $feedback['comment']) }}</textarea>
                                    @error('comment')
                                        <label for="comment" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="user">User</label>
                                    <select id="user" name="user" class="form-control @error('user') is-invalid @enderror"
                                            required>
                                        @php $u = old('user', $feedback['user_id']); @endphp
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}" @if ($u == $user['id']) selected @endif>
                                                {{ $user['email'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user')
                                        <label for="user" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('admin.feedback.index') }}" class="btn btn-danger ml-2">Cancel</a>
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
            $('#response_time').on('input', function() {
                let text = ''
                switch ($(this).val()) {
                    case '1': text = '1 Hour'; break
                    case '2': text = '1 Day'; break
                    case '3': text = '1 Week'; break
                    case '4': text = '1 Month'; break
                }
                $('#response-time-value').text(text)
            })
        })
    </script>
@endsection
