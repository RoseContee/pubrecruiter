@extends('admin.partials.layout')

@php
    $add = empty($contact);
    $title = $add ? 'Add Creator' : 'Edit Creator';
    $url = $add ? route('admin.contacts.store', ['type' => $submenu]) : route('admin.contacts.update', $contact['id']);
    $old = !empty(old());
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
                        <li class="breadcrumb-item active">Contacts</li>
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
                                    <label for="active">Show In Marketplace</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="active" name="active" class="custom-control-input"
                                               value="1" @if (old('active', $old ? null : ($contact['active']??1))) checked @endif>
                                        <label for="active" class="custom-control-label">Show</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="featured">Featured Option</label>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="featured" name="featured" class="custom-control-input"
                                               value="1" @if (old('featured', $old ? null : ($contact['featured']??null))) checked @endif>
                                        <label for="featured" class="custom-control-label">Featured</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="owner">Creator Owner</label>
                                    <select id="owner" name="owner"
                                            class="form-control @error('owner') is-invalid @enderror" required>
                                        @php
                                            $owner = old('owner', !$add && $contact['owner_type'] == \App\Models\User::class ? $contact['owner_id'] : '');
                                        @endphp
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}" data-ref="{{ json_encode($user) }}"
                                                    @if ($owner == $user['id']) selected @endif>
                                                {{ $user['email'] }}
                                            </option>
                                        @endforeach
                                        <option value="" data-ref="{{ json_encode($info) }}"
                                            @if (($old && !old('owner')) ||
                                                    (!$add && $contact['owner_type'] == \App\Models\Admin::class))
                                                selected
                                            @endif>
                                            Admin
                                        </option>
                                    </select>
                                    @error('owner')
                                        <label for="owner" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div id="owner-info">
                                    <div class="form-group">
                                        <label for="email">Contact Email</label>
                                        <input type="email" id="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', !$add ? $contact->contact_email() : '') }}"
                                               placeholder="Enter contact email" required>
                                        @error('email')
                                            <label for="email" class="small text-danger font-weight-normal mb-0">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Name of Website/Social Media</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', !$add ? $contact->contact_name() : '') }}"
                                               placeholder="Enter name of website" required>
                                        @error('name')
                                            <label for="name" class="small text-danger font-weight-normal mb-0">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="website">Website/Social Media URL</label>
                                    <input type="text" id="website" name="website"
                                           class="form-control @if($errors->has('website') || $errors->has('domain')) is-invalid @endif"
                                           value="{{ old('website', $contact['website']??'') }}"
                                           placeholder="Enter brand URL" required>
                                    @if ($errors->has('website') || $errors->has('domain'))
                                        <label for="website" class="small text-danger font-weight-normal mb-0">
                                            {{ $errors->has('website') ? $errors->first('website') : $errors->first('domain') }}
                                        </label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="tags">Tags</label>
                                    <input type="text" id="tags" name="tags"
                                           class="form-control @error('tags') is-invalid @enderror"
                                           value="{{ old('tags', $contact['tags']??'') }}"
                                           placeholder="Enter tags">
                                    @error('tags')
                                        <label for="tags" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>What are you interested in?</label>
                                    <div class="custom-control custom-checkbox mb-1">
                                        <input type="checkbox" id="offers" name="offers" class="custom-control-input"
                                               value="1" @if (old('offers', $old ? null : ($contact['offers']??null))) checked @endif>
                                        <label for="offers" class="custom-control-label">Affiliate Offers</label>
                                    </div>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" id="posts" name="posts" class="custom-control-input"
                                               value="1" @if (old('posts', $old ? null : ($contact['posts']??null))) checked @endif>
                                        <label for="posts" class="custom-control-label">Sponsored Posts</label>
                                    </div>
                                </div>
                                @if (count($metrics))
                                    <hr>
                                    <h5 class="mb-3">Business Metrics</h5>
                                    @foreach ($metrics as $metric)
                                        <div class="form-group">
                                            <label for="metric{{ $metric['id'] }}">{{ $metric['type'] }}</label>
                                            <input type="text" id="metric{{ $metric['id'] }}" name="metric{{ $metric['id'] }}"
                                                   value="{{ old('metric'.$metric['id'], $user_metrics[$metric['id']] ?? '') }}"
                                                   class="form-control @error('metric'.$metric['id']) is-invalid @enderror"
                                                   placeholder="Enter {{ $metric['type'] }}">
                                            <label for="metric{{ $metric['id'] }}" class="d-block small font-weight-normal mb-0" style="line-height:1.5;">
                                                ex: 10000, 10K, 7.1M
                                            </label>
                                            @error('metric'.$metric['id'])
                                                <label for="metric{{ $metric['id'] }}" class="d-block small text-danger font-weight-normal mb-0" style="line-height:1.3;">
                                                    {{ $message }}
                                                </label>
                                            @enderror
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{ $add ? 'Create' : 'Update' }}</button>
                                <a href="{{ route('admin.contacts.index', ['type' => $submenu]) }}"
                                   class="btn btn-danger ml-2">Cancel</a>
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
            $('#owner').on('change', function() {
                toggleOwnerInfo()
            })

            toggleOwnerInfo()
        })

        function toggleOwnerInfo() {
            const owner = $('#owner'), ref = owner.find('option:selected').data('ref')
            try {
                $('#email').val(ref.email)
                $('#name').val(ref.name)
            } catch(e) {}
            if (owner.val()) {
                owner.attr('required', 'required')
                $('#email').removeAttr('required')
                $('#name').removeAttr('required')
                $('#owner-info').hide()
            } else {
                owner.removeAttr('required')
                $('#email').attr('required', 'required')
                $('#name').attr('required', 'required')
                $('#owner-info').show()
            }
        }
    </script>
@endsection
