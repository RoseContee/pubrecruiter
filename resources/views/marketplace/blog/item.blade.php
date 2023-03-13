@extends('marketplace.partials.layout')

@section('title', $blog['title'])

@section('header-menu')
    <ul class="navbar-nav align-items-center justify-content-around ml-auto">
        <li class="nav-item">
            <a href="{{ route('blog') }}" class="btn font-weight-bold mr-3">
                Blog
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('login') }}" class="btn btn-main btn-round fs-16 text-capitalize font-weight-bold px-5">
                Login
            </a>
        </li>
    </ul>
@endsection

@section('content')
    <!--Main Start-->
    <main class="blog mt-5">
        <div class="container pt-5">
            <div class="row">
                <div class="col-12 text-center">
                    <h1>{{ $blog['title'] }}</h1>
                    <p>Last Modified: {{ date('F j, Y', strtotime($blog['updated_at'])) }}</p>
                </div>
                <div class="col-12 text-center">
                    <img src="{{ asset('public/'.$blog['image']) }}" alt="image" class="blog-image">
                </div>
                <div class="col-12">
                    <div class="text-dark mt-5">
                        {!! $blog['content'] !!}
                    </div>
                </div>
            </div>
            <hr>
            <div class="blog-tagshare">
                <div class="blog-tags">
                    <span>Tags:</span>
                    @php
                        $tags = preg_split('/\s*,\s*/', trim($blog['tags']), -1, PREG_SPLIT_NO_EMPTY);
                    @endphp
                    @foreach ($tags as $tag)
                        <a href="{{ route('category-blog', $tag) }}">{{ $tag }}</a>
                    @endforeach
                </div>
                <div class="blog-share">
                    <span>Share this blog</span>
                    <a href="javascript:void(0);" onclick="shareFacebook()">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="javascript:void(0);" onclick="shareTwitter()">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="javascript:void(0);" onclick="shareLinkedin()">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
            <hr>
            <div class="row recommendations">
                <div class="col-sm-6">
                    @if ($old)
                        <h6 class="my-1">
                            <a href="{{ route('blog-item', $old['slug']) }}" class="d-flex align-items-center">
                                <i class="fa fa-angle-double-left"></i>
                                <span class="ml-2">{{ $old['title'] }}</span>
                            </a>
                        </h6>
                    @endif
                </div>
                <div class="col-sm-6">
                    @if ($new)
                        <h6 class="my-1">
                            <a href="{{ route('blog-item', $new['slug']) }}"
                               class="d-flex align-items-center justify-content-end">
                                <span class="mr-2">{{ $new['title'] }}</span>
                                <i class="fa fa-angle-double-right"></i>
                            </a>
                        </h6>
                    @endif
                </div>
            </div>
            <hr>
            <div class="row mt-5">
                <div class="col-sm-6">
                    <h5 class="my-2">Comments</h5>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-main my-2"
                            data-toggle="collapse" data-target="#comment-form">Post Comment</button>
                </div>
            </div>
            <div id="comment-form" class="collapse mt-4">
                <p class="text-center">Leave a comment</p>
                <form action="{{ route('blog-comment', $blog['slug']) }}" method="POST">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea id="comment" name="comment" class="form-control" rows="5"
                                      placeholder="Enter a comment" required></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-main">Submit</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div id="blog-comments-list">
                @foreach ($comments as $comment)
                    @include('marketplace.blog.comment-item')
                @endforeach
            </div>
            @if ($comments->hasMorePages())
                <div class="text-center mt-2">
                    <button id="view-more" class="btn btn-main btn-sm small"
                            data-next="{{ $comments->nextPageUrl() }}">
                        <i class="fa fa-spinner fa-spin display-none"></i> View More
                    </button>
                </div>
            @endif
        </div>
    </main>
    <!--Main End-->
@endsection

@push('script')
    <script type="application/javascript">
        $(function() {
            $(document).on('click', '#view-more:not(:disabled)', function() {
                let that = $(this), url = that.data('next')
                if (!url) return that.parent().remove()
                that.attr('disabled', 'disabled').find('i').show()
                $.ajax({
                    url: url,
                    method: 'GET',
                    success(data) {
                        if (data.comments) {
                            $('#blog-comments-list').append(data.comments)
                        }
                        if (data.next) {
                            that.data('next', data.next)
                                .removeAttr('disabled')
                                .find('i')
                                .hide()
                        } else {
                            that.parent().remove()
                        }
                    },
                    error(data) {
                        location.reload()
                    }
                })
            })
        })

        const windowLocation = '{{ route('blog-item', $blog['slug']) }}'
        const pageTitle = '{{ $blog['title'] }}'
        function shareFacebook() {
            window.open('https://www.facebook.com/sharer/sharer.php?u=' + windowLocation, "facebookWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0")
            return false
        }

        function shareTwitter() {
            window.open('http://twitter.com/intent/tweet?text=' + pageTitle + ' ' + windowLocation, "twitterWindow", "height=380,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0")
            return false
        }

        function shareLinkedin() {
            window.open('http://www.linkedin.com/shareArticle?mini=true&url=' + windowLocation + '&title=' + pageTitle + '', "linkedInWindow", "height=480,width=660,resizable=0,toolbar=0,menubar=0,status=0,location=0,scrollbars=0")
            return false
        }
    </script>
@endpush
