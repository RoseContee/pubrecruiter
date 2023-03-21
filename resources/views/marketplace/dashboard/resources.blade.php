@extends('marketplace.dashboard.layout')

@section('title', 'Recommended Resources')

@section('content')
    <!--Main Start-->
    <main id="main-container">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Recommended Resources
                </h3>
            </div>
            <div class="card-body">
                @if (count($resources))
                    <div class="row">
                        @foreach ($resources as $resource)
                            <div class="col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3">
                                <div class="contact-item text-center border p-4 h-100">
                                    <a href="{{ $resource['url'] }}" class="text-dark" target="_blank">
                                        <h4 class="mt-3 mb-3">{{ $resource['name'] }}</h4>
                                        <figure>
                                            @if ($resource['logo'] && file_exists(public_path($resource['logo'])))
                                                <img src="{{ asset('public/'.$resource['logo']) }}" alt="Logo">
                                            @endif
                                        </figure>
                                        <p class="small font-weight-bold my-2">{{ $resource['note'] }}</p>
                                    </a>
                                    <a href="{{ $resource['url'] }}"
                                       class="btn btn-main btn-sm btn-block text-truncate" target="_blank">
                                        Go to
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-3 text-center pagination-center">
                        {!! $resources->links('vendor.pagination.simple-bootstrap-4') !!}
                    </div>
                @else
                    <h6 class="font-italic py-5">No resource found</h6>
                @endif
            </div>
        </div>
    </main>
    <!--Main End-->
@endsection

@push('script')
    <script type="text/javascript">
    </script>
@endpush
