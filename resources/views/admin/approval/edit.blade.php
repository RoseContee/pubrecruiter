@extends('admin.partials.layout')

@section('title', 'Approval User')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Approval User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Approval</li>
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
                        <form action="{{ route('admin.approval.update', $user['id']) }}" method="POST">
                            @method('PUT')
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Brand/Creator Name</label>
                                    <div class="form-control">{{ $user['name'] }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <div class="form-control">{{ $user['email'] }}</div>
                                </div>
                                <div class="form-group">
                                    <label for="paid_at">Paid At</label>
                                    <input type="text" id="paid_at" name="paid_at" class="form-control @error('paid_at') is-invalid @enderror"
                                           value="{{ old('paid_at', $user['paid_at']) }}" placeholder="Enter paid date"
                                           data-target="#timepicker" data-toggle="datetimepicker">
                                    @error('expires')
                                        <label for="paid_at" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="expires">Expires</label>
                                    <input type="text" id="expires" name="expires" class="form-control @error('expires') is-invalid @enderror"
                                           value="{{ old('expires', $user['expires']) }}" placeholder="Enter expires" required
                                           data-target="#timepicker" data-toggle="datetimepicker">
                                    @error('expires')
                                        <label for="expires" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Approve</button>
                                <a href="{{ route('admin.approval') }}" class="btn btn-danger ml-2">Cancel</a>
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
            $('#paid_at').datetimepicker({
                format: 'YYYY-MM-DD',
            })
            $('#expires').datetimepicker({
                format: 'YYYY-MM-DD',
            })
        })
    </script>
@endsection
