@extends('marketplace.dashboard.layout')

@php
    $add = empty($outreach);
    $brand_user = auth()->user()->type == 'Brand';
@endphp
@section('title', ($add ? 'Add' : 'Edit').' Outreach')

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="row">
            <div class="col-md-12 col-lg-10 col-xl-8">

                @include('marketplace.partials.messages')

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $add ? 'Add' : 'Edit' }} Outreach
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ $add ? route('new-outreach') : route('edit-outreach', $outreach['id']) }}" method="POST">
                                    @csrf
                                    @if (!$add)
                                        @method('PUT')
                                    @endif
                                    <fieldset>
                                        <div class="form-group">
                                            <label for="name">{{ $brand_user ? 'Name of website' : 'Brand Name' }}</label>
                                            <input type="text" id="name" name="name"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   placeholder="Name" required
                                                   value="{{ old('name', !$add ? $outreach['name'] : '') }}">
                                            @error('name')
                                                <label for="name" class="text-danger small">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   placeholder="Email" required
                                                   value="{{ old('name', !$add ? $outreach['email'] : '') }}">
                                            @error('email')
                                                <label for="email" class="text-danger small">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="description">{{ $brand_user ? 'Notes' : 'Description' }}</label>
                                            <input type="text" id="description" name="description"
                                                   class="form-control @error('description') is-invalid @enderror"
                                                   placeholder="Description" required
                                                   value="{{ old('name', !$add ? $outreach['description'] : '') }}">
                                            @error('description')
                                                <label for="description" class="text-danger small">{{ $message }}</label>
                                            @enderror
                                        </div>
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-main">{{ $add ? 'Add' : 'Update' }}</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
