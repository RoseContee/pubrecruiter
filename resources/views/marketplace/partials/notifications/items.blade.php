@foreach ($notis as $noti)
    @php
      $type = get_class($noti) == \App\Models\Outreach::class ? 'outreach' : 'recommendation'
    @endphp
    <li class="noti">
        <a href="javascript:void(0);" class="not-seen"
           data-ref="{{ $noti['id'] }}"
           data-type="{{ $type }}">
            @if ($type == 'recommendation')
                <b>{{ $noti['recommendation']['name']??'Someone' }}</b> is recommended!
            @elseif ($noti['opportunities'])
                <b>{{ $noti['user']['name']??'Someone' }}</b> is interested in one of your opportunities!
            @else
                <b>{{ $noti['user']['name']??'Someone' }}</b> wants to partner with you!
            @endif
        </a>
    </li>
@endforeach
