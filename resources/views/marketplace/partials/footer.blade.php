<footer class="text-center py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 mb-3 mb-lg-0 text-lg-left">
                <img src="{{ asset('public/assets/images/logo-footer.png') }}" alt="logo" class="logo">
            </div>
            <div class="col-lg-9">
                <ul class="d-block d-lg-flex justify-content-end align-items-center">
                    <li class="px-2 mt-2">
                        <a href="{{ $setting['extension_link'] }}" class="btn btn-main btn-sm" target="_blank">
                            <i class="fab fa-chrome"></i> Download
                        </a>
                    </li>
                    <li class="pl-2 mt-2">
                        <span class="text-white">&copy;{{ date('Y') }} {{ $setting['site_name'] }} - All Rights Reserved</span>
                    </li>
                    <li class="pl-2 mt-2 text-white">
                        <a href="https://book.pubrecruiter.com" class="text-white ml-0 ml-lg-4 mr-2">Support</a>
                        |
                        <a href="https://book.pubrecruiter.com/policies" class="text-white ml-2">Policies</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
