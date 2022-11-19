@foreach ($notis as $noti)
    <li class="noti">
        <a href="javascript:void(0);" class="not-seen"
           data-ref="{{ $noti['id'] }}">
            @if ($noti['opportunities'])
                <b>{{ $noti['user']['name']??'Someone' }}</b> is interested in one of your opportunities!
            @else
                <b>{{ $noti['user']['name']??'Someone' }}</b> wants to partner with you!
            @endif
        </a>
    </li>
@endforeach
