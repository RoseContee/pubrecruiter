@extends('admin.partials.layout')

@php
    $add = empty($contact);
    $title = $add ? 'Add Brand' : 'Edit Brand';
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
                                    <label for="owner">Brand Owner</label>
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
                                        <label for="name">Brand Name</label>
                                        <input type="text" id="name" name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               value="{{ old('name', !$add ? $contact->contact_name() : '') }}"
                                               placeholder="Enter brand name" required>
                                        @error('name')
                                            <label for="name" class="small text-danger font-weight-normal mb-0">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="brand_url">Brand URL</label>
                                    <input type="url" id="brand_url" name="brand_url"
                                           class="form-control @if ($errors->has('brand_url') || $errors->has('domain')) is-invalid @endif"
                                           value="{{ old('brand_url', $contact['website']??'') }}"
                                           placeholder="Enter Brand URL" required>
                                    @if ($errors->has('brand_url') || $errors->has('domain'))
                                        <label for="brand_url" class="small text-danger font-weight-normal mb-0">
                                            {{ $errors->has('brand_url') ? $errors->first('brand_url') : $errors->first('domain') }}
                                        </label>
                                    @endif
                                </div>
                                @if ($contact['logo']??'' && file_exists(public_path($contact['logo'])))
                                    <div class="form-group text-center">
                                        <img src="{{ asset('public/'.$contact['logo']) }}" class="img-fluid"
                                             alt="{{ $contact['name'] }}" style="width: 220px; height: 110px;">
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="logo">Logo</label>
                                    <div class="input-group">
                                        <div class="custom-file @error('logo') is-invalid @enderror">
                                            <input type="file" id="logo" name="logo"
                                                   class="custom-file-input" accept="image/*">
                                            <label class="custom-file-label" for="logo">Choose file</label>
                                        </div>
                                    </div>
                                    @error('logo')
                                        <label for="logo" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                    <label for="logo" class="small font-weight-bold mb-0">Preferred Ratio: 2:1</label>
                                </div>
                                <div class="form-group text-center">
                                    <label>Preview</label>
                                    <div class="row">
                                        <div class="col-12">
                                            <canvas id="preview" width="220" height="110" style="background-color:#c9c9c9;"></canvas>
                                        </div>
                                    </div>
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
                                    <label for="network">Network</label>
                                    <select id="network" name="network"
                                            class="form-control @error('network') is-invalid @enderror">
                                        @php $n = old('network', $contact['network_id'] ?? ''); @endphp
                                        @foreach ($networks as $network)
                                            <option value="{{ $network['id'] }}" {{ $n == $network['id'] ? 'selected' : '' }}>
                                                {{ $network['name'] }}
                                            </option>
                                        @endforeach
                                        <option value="" {{ old('email') && !old('network') }}>Other</option>
                                    </select>
                                    @error('network')
                                        <label for="network" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
                                <div id="other-network" style="display:none;">
                                    <div class="form-group">
                                        <label for="network_name">Network</label>
                                        <input type="text" id="network_name" name="network_name"
                                               class="form-control @error('network_name') is-invalid @enderror"
                                               value="{{ old('network_name', $contact['network']??'') }}"
                                               placeholder="Enter network">
                                        @error('network_name')
                                            <label for="network_name" class="small text-danger font-weight-normal mb-0">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="network_link">Network Link</label>
                                        <input type="url" id="network_link" name="network_link"
                                               class="form-control @error('network_link') is-invalid @enderror"
                                               value="{{ old('network_link', $contact['network_link']??'') }}"
                                               placeholder="Enter network link">
                                        @error('network_link')
                                            <label for="network_link" class="small text-danger font-weight-normal mb-0">
                                                {{ $message }}
                                            </label>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Commission</label>
                                    <div class="form-inline">
                                        <input type="number" id="commission" name="commission"
                                               class="form-control @error('commission') is-invalid @enderror"
                                               value="{{ old('commission', $contact['commission']??'') }}"
                                               placeholder="Enter commission">
                                        <select name="commission_type" class="form-control">
                                            @php $commission_type = old('commission_type', $contact['commission_type']??''); @endphp
                                            <option value="dollar"
                                                    @if (in_array($commission_type, ['dollar', '$'])) selected @endif>
                                                dollar
                                            </option>
                                            <option value="percentage"
                                                    @if (in_array($commission_type, ['percentage', '%'])) selected @endif>
                                                percentage
                                            </option>
                                        </select>
                                        <select id="commission_unit" name="commission_unit" class="form-control">
                                            @php $commission_unit = old('commission_unit', $contact['commission_unit']??''); @endphp
                                            <option value="Per Sale" @if ($commission_unit == 'Per Sale' || !$commission_unit) selected @endif>
                                                Per Sale
                                            </option>
                                            <option value="Per Lead" @if ($commission_unit == 'Per Lead') selected @endif>
                                                Per Lead
                                            </option>
                                            <option value="Per Sign Up" @if ($commission_unit == 'Per Sign Up') selected @endif>
                                                Per Sign Up
                                            </option>
                                            <option value="custom"
                                                    @if($commission_unit && !in_array($commission_unit, ['Per Sale', 'Per Lead', 'Per Sign Up'])) selected @endif>
                                                Custom
                                            </option>
                                        </select>
                                        <input type="text" id="commission_custom_unit" name="commission_custom_unit"
                                               class="form-control"
                                               @if(!$commission_unit || in_array($commission_unit, ['Per Sale', 'Per Lead', 'Per Sign Up'])) style="display: none;" @endif
                                               value="{{ old('commission_custom_unit', $contact['commission_unit']??'') }}"
                                               placeholder="Enter custom">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exclusive_deal">Exclusive Deal Link</label>
                                    <input type="url" id="exclusive_deal" name="exclusive_deal"
                                           class="form-control @error('exclusive_deal') is-invalid @enderror"
                                           value="{{ old('exclusive_deal', $contact['exclusive_deal']??'') }}"
                                           placeholder="Enter exclusive deal link">
                                    @error('exclusive_deal')
                                        <label for="exclusive_deal" class="small text-danger font-weight-normal mb-0">
                                            {{ $message }}
                                        </label>
                                    @enderror
                                </div>
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

            $('#logo').on('change', async function(e) {
                let canvas = document.getElementById('preview')
                let ctx = canvas.getContext('2d')
                if (e.target.files.length) {
                    let img = await blobToBase64(e.target.files[0])
                    img = await getImageObject(img)
                    ctx.drawImage(img, 0, 0, img.width, img.height, 0, 0, 220, 110)
                } else {
                    ctx.clearRect(0, 0, 220, 110)
                }
            })

            $('#network').on('change', function() {
                toggleOtherNetwork()
            })

            $('#commission_unit').on('change', function() {
                if ($(this).val() == 'custom') $('#commission_custom_unit').show()
                else $('#commission_custom_unit').hide()
            })

            toggleOwnerInfo()
            toggleOtherNetwork()
            bsCustomFileInput.init()
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

        function toggleOtherNetwork() {
            if ($('#network').val()) {
                $('#network_name').removeAttr('required')
                $('#network_link').removeAttr('required')
                $('#other-network').hide()
            } else {
                $('#network_name').attr('required', 'required').val('')
                $('#network_link').attr('required', 'required').val('')
                $('#other-network').show()
            }
        }
    </script>
@endsection
