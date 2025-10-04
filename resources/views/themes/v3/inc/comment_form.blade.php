<div class="row">
    <div class="col-12 mb-4">
        <div class="comment-block shadow-sm p-4 overflow-hidden rounded-1">
            <div class="news-headline-block justify-content-between mb-4"> <!--Block Başlık-->
                <h2 class="text-black">@lang('frontend.a_comment')</h2>
                <div class="headline-block-indicator border-0">
                    <div class="indicator-ball" style="background-color:#EC0000;"></div>
                </div>
            </div>
            <p class="comment-desc text-danger">@lang('frontend.comment_info_email')</p>

            <div class="comment-form">
                <form action="{{ route('commentsubmit', ['type' => $type, 'post_id' => $id]) }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <textarea name="detail" class="form-control" id="commentMessage" aria-describedby="commentMessage"
                            placeholder="@lang('frontend.leave_a_comment')"></textarea>
                        <div id="commentReply"></div>
                    </div>
                    <div class="mb-3">
                        <input name="name" type="text" class="form-control" id="commentName"
                            aria-describedby="commentName" placeholder="@lang('frontend.name_placeholder')">
                    </div>
                    <div class="mb-3">
                        <input name="email" type="email" class="form-control" id="CommentEmail"
                            aria-describedby="CommentEmail" placeholder="@lang('frontend.email_placeholder')">
                    </div>
                    @if ($magicbox['google_recaptcha_site_key'] != null)
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ $magicbox['google_recaptcha_site_key'] }}">
                            </div>
                        </div>
                        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
                    @endif
                    @if (session('captcha_error'))
                        <div class="alert alert-danger mb-3" role="alert">
                            {{ session('captcha_error') }}
                        </div>
                    @endif
                    @if (session('success_comment'))
                        <div class="alert alert-success mb-3" role="alert">
                            {{ session('success_comment') }}
                        </div>
                    @endif
                    <div class="mb-4 text-end">
                        <button type="submit" class="btn btn-comment">@lang('frontend.send_comment')</button>
                    </div>
                </form>
            </div>

            <div class="comments-list">
                <div class="comments-header justify-content-between">
                    <div class="comments-header-title">
                        @lang('frontend.comments')<span>({{ isset($comments) ? count($comments) : 0 }} @lang('frontend.comment'))</span>
                    </div>
                    <div class="comments-sorts d-none">
                        @lang('frontend.order_comments')
                        <select name="" id="comments-sort">
                            <option value=""> @lang('frontend.most_popular') </option>
                            <option value=""> @lang('frontend.newest') </option>
                            <option value=""> @lang('frontend.most_liked') </option>
                        </select>
                    </div>
                </div>

                @if (isset($comments) && count($comments) > 0)
                    @foreach ($comments as $comment)
                        <div class="comment-item">
                            <div class="comment-user-image">
                                <img src="{{ asset('frontend/assets/images/user-profile.jpg') }}"
                                    alt="{{ $comment->title }}" class="img-fluid lazy">
                            </div>
                            <div class="comment-item-title">
                                {{ $comment->title }} <span
                                    class="comment-date">{{ date('d M Y, H:i', strtotime($comment->created_at)) }}</span>
                            </div>
                            <p class="comment-message">{{ $comment->detail }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="no-comments">
                        <p>@lang('frontend.no_comments_yet')</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
