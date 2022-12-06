@extends('admin.partials.layout')

@php
    $add = empty($commission);
    $title = $add ? 'Add Commission' : 'Edit Commission';
    $url = $add ? route('admin.commissions.store') : route('admin.commissions.update', $commission['id']);
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
                        <li class="breadcrumb-item active">Commissions</li>
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
                        <form action="{{ $url }}" method="POST">
                            @if (!$add)
                                @method('PUT')
                            @endif
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="creator">Creator</label>
                                    <select id="creator" name="creator" class="form-control @error('creator') is-invalid @enderror">
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}" @if ($user['id'] == ($commission['user_id']??'')) selected @endif>
                                                {{ $user['name'] }} ( {{ $user['email'] }} )
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('creator')
                                        <label for="creator" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="brand">Brand</label>
                                    <input type="text" id="brand" name="brand" class="form-control @error('brand') is-invalid @enderror"
                                           value="{{ old('brand', $commission['brand']??'') }}" placeholder="Enter brand" required>
                                    @error('brand')
                                        <label for="brand" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="commission">Creator Commission</label>
                                    <input type="number" id="commission" name="commission" class="form-control @error('commission') is-invalid @enderror"
                                           value="{{ old('commission', $commission['commission']??'') }}" placeholder="Enter commission" required>
                                    @error('commission')
                                        <label for="commission" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="admin_commission">Pub Recruiter Commission</label>
                                    <input type="number" id="admin_commission" name="admin_commission" class="form-control @error('admin_commission') is-invalid @enderror"
                                           value="{{ old('admin_commission', $commission['admin_commission']??'') }}" placeholder="Enter commission" required>
                                    @error('admin_commission')
                                        <label for="commission" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date">Date of Transaction</label>
                                    <input type="text" id="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                           value="{{ old('date', $commission['date']??'') }}" placeholder="Enter date" required
                                           data-target="#timepicker" data-toggle="datetimepicker">
                                    @error('date')
                                        <label for="commission" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="paid">Paid?</label>
                                    <select id="paid" name="paid" class="form-control @error('paid') is-invalid @enderror">
                                        @php $paid = old('paid', $commission['paid']??0); @endphp
                                        <option value="1" @if ($paid == 1) selected @endif>Yes</option>
                                        <option value="0" @if ($paid == 0) selected @endif>No</option>
                                    </select>
                                    @error('paid')
                                        <label for="paid" class="small text-danger font-weight-normal mb-0">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.commissions.index') }}" class="btn btn-danger ml-2">Cancel</a>
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
            $('#date').datetimepicker({
                format: 'YYYY-MM-DD',
            })
        })
    </script>
@endsection
