@if ($message = session('info_message'))
    <div class="alert alert-info alert-dismissible fade show">
        <span>{!! $message !!}</span>
        <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></a>
    </div>
@endif
@if ($message = session('success_message'))
    <div class="alert alert-success alert-dismissible fade show">
        <span>{!! $message !!}</span>
        <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></a>
    </div>
@endif
@if ($message = session('warning_message'))
    <div class="alert alert-warning alert-dismissible fade show">
        <span>{!! $message !!}</span>
        <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></a>
    </div>
@endif
@if ($message = session('error_message'))
    <div class="alert alert-danger alert-dismissible fade show">
        <span>{!! $message !!}</span>
        <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="Close"><i class="fa fa-times"></i></a>
    </div>
@endif
