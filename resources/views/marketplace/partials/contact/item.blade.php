<div class="{{ !empty($class) ? $class : 'col-12 col-xs-6 col-sm-6 col-md-4 col-lg-3 pb-4' }}">
    <div class="contact-item text-center border p-4 h-100">
        @auth
            <a href="javascript:void(0);" class="favorite-brand" data-ref="{{ $contact['id'] }}">
                @if (in_array($contact['id'], $favorites))
                    <i class="fa fa-heart fa-2x"></i>
                @else
                    <i class="far fa-heart fa-2x"></i>
                @endif
            </a>
        @endauth
        @if ($contact['type'] == 'Creator' && !empty($contact['metric']['number']) && !empty($contact['metric']['metric']))
            <span class="metric">
                    {{ number_short_format($contact['metric']['number']) }} {{ $contact['metric']['metric']['type'] }}
            </span>
        @endif
        <a href="{{ $contact['website'] }}" class="text-dark" target="_blank">
            @if ($contact['type'] == 'Brand')
                <h4 class="mt-3 mb-3">
                    {{ $contact->contact_name() }} <i class="fa fa-external-link-alt"></i>
                </h4>
                <figure>
                    @if ($contact['logo'] && file_exists(public_path($contact['logo'])))
                        <img src="{{ asset('public/'.$contact['logo']) }}" alt="Logo">
                    @endif
                </figure>
                <h5 class="mb-0">{{ $contact['tags'] }}&nbsp;</h5>
                <p class="small font-weight-bold">
                    @if ($contact['commission'])
                        @php $commission = ltrim(rtrim($contact['commission_type'].$contact['commission'].$contact['commission_type'], '$'), '%'); @endphp
                        Commission: {{ $commission }} {{ $contact['commission_unit'] }}
                    @else
                        &nbsp;
                    @endif
                </p>
            @else
                <h4 class="mt-3 @auth mb-2 @endauth">
                    {{ $contact->contact_name() }} <i class="fa fa-external-link-alt"></i>
                </h4>
                <h5 @auth class="mb-3" @endauth>{{ $contact['tags'] }}&nbsp;</h5>
                <p class="font-weight-bold @if (auth()->check()) mb-2 @else mb-3 @endif">Interested In:</p>
                <div class="row @if (auth()->check()) mb-1 @else mb-2 @endif">
                    <div class="col-4 text-right small pl-0">
                        @if ($contact['posts'])<i class="fa fa-check fa-2x text-success"></i>@endif
                    </div>
                    <div class="col-8 text-left small px-0">Sponsored Posts</div>
                </div>
                <div class="row @if (auth()->check()) mb-1 @else mb-3 @endif">
                    <div class="col-4 text-right small pl-0">
                        @if ($contact['offers'])<i class="fa fa-check fa-2x text-success"></i>@endif
                    </div>
                    <div class="col-8 text-left small px-0">Affiliate Offers</div>
                </div>
            @endif
        </a>
        @if ($contact['type'] == 'Brand')
            <button class="btn btn-main btn-sm btn-block text-truncate visibility-hidden mb-2">&nbsp;</button>
            <div class="position-relative mb-2">
                @if ($contact['exclusive_deal'])
                    <div class="exclusive-info">
                        <a href="javascript:void(0);" data-toggle="tooltip"
                           title="Creators get expedited access to Affiliate links.  Share to earn when a user buys!">
                            <i class="fa fa-info-circle"></i>
                        </a>
                    </div>
                @endif
                @if (!auth()->check() && $contact['exclusive_deal'])
                    <button class="btn btn-main btn-sm btn-block text-truncate"
                       data-toggle="modal" data-target="#signinModal">
                        Copy Affiliate Link <i class="fa fa-copy"></i>
                    </button>
                @elseif ($contact['exclusive_deal'])
                    <button data-link="{{ str_replace('{USERID}', auth()->id(), $contact['exclusive_deal']) }}"
                       class="btn btn-main btn-sm btn-block text-truncate copy-affiliate-link">
                        Copy Affiliate Link <i class="fa fa-copy"></i>
                    </button>
                @else
                    <button class="btn btn-main btn-sm btn-block text-truncate visibility-hidden">&nbsp;</button>
                @endif
            </div>
        @endif
        @if ($contact['type'] == 'Creator')
            @if (count($opportunities = $contact['user']['opportunities']))
                <button class="btn btn-main btn-sm btn-block text-truncate view-opportunities"
                        data-opportunities="{{ json_encode($opportunities) }}"
                        @auth
                            data-media-kit="{{ $contact['user']['info']['media_kit_link']??'' }}"
                            data-ref="{{ $contact['id'] }}"
                        @endauth
                >
                    View Opportunities
                </button>
            @else
                <button class="btn btn-main btn-sm btn-block text-truncate visibility-hidden">&nbsp;</button>
            @endif
        @endif
        @if (auth()->check())
            @if (in_array($contact['id'], $sent))
                <button class="btn btn-main btn-sm btn-block text-truncate" disabled>
                    <i class="fa fa-check"></i>
                </button>
            @else
                <button class="btn btn-main btn-sm btn-block text-truncate request-partnership"
                   @if($contact['type'] == 'Brand') data-href="{{ str_replace('{USERID}', auth()->id(), $contact['network_link']) }}" @endif
                   data-ref="{{ $contact['id'] }}">
                    Request Partnership
                </button>
            @endif
        @else
            <button class="btn btn-main btn-sm btn-block text-truncate"
               data-toggle="modal" data-target="#signinModal">
                Request Partnership
            </button>
        @endif
    </div>
</div>
