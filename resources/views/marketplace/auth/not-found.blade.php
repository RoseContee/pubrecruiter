@extends('marketplace.auth.layout')

@section('title', 'Not found')

@section('content')
    <!--Main Start-->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-6">
                @if (!empty($error_message))
                    <div class="alert text-danger text-center">
                        {{ $error_message }}
                    </div>
                @endif
                @if (!empty($info_message))
                    <div class="alert text-info text-center">
                        {{ $info_message }}
                    </div>
                @endif
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection
