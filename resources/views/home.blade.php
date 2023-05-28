@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 sidebar-page-container">
                <div class="sidebar">
                    <div class="sidebar-widget sidebar-post">
                        <div class="widget-title row pt-3">
                            <div class="col-2">
                            <h3>Post Feed</h3>
                            </div>
                            <div class="col-6">
                            <button class="btn btn-primary" onclick="window.location.href='/posts/create';">Post</button>
                            </div>
                        </div>
                        <div class="post-inner pt-4">
                            <div class="carousel-inner-data">
                                <ul>
                                    @foreach ($posts as $post)
                                        <li>
                                            <div class="post">
                                                <div class="post-date">
                                                    <p>{{ $post->created_at->format('d') }}</p>
                                                    <span>{{ \Carbon\Carbon::parse($post->created_at)->format('F') }}</span>
                                                </div>
                                                <div class="file-box">
                                                <div class="profile-pic">
                                                    <img src="{{ asset('storage/profile_pictures/'.$post->user->profile_picture) }}" alt="Profile Picture">
                                                    </div>
                                                    <b>{{ $post->user->name }}</b>
                                                </div>
                                                <p>{{ $post->description }}</p>
                                            </div>
                                            <span id="likes-count-{{ $post->id }}">{{ $post->like_count }}</span><button class="like-button{{ $post->likedByUser() ? ' active' : '' }}" data-post="{{ $post->id }}" style="border: none; color: #fff;"> <img src="{{ asset('img/like.png') }}" height="25px" width="25px" /></button>
                                            <span id="dislikes-count-{{ $post->id }}">{{ $post->dislike_count }}</span><button class="dislike-button{{ $post->dislikedByUser() ? ' active' : '' }}" data-post="{{ $post->id }}" style="border: none; color: #fff;"> <img src="{{ asset('img/dislike.png') }}" height="30px" width="30px" /></button>
                                            <span id="bookmarks-count-{{ $post->id }}">{{ $post->bookmarks_count }}</span><button class="bookmark-button" data-post="{{ $post->id }}" style="border: none; color: #fff;"> <img src="{{ asset('img/bookmark.png') }}" height="30px" width="30px" /></button>
                                            <hr>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.like-button').on('click', function () {
                var postId = $(this).data('post');
                likePost(postId);
            });

            $('.dislike-button').on('click', function () {
                var postId = $(this).data('post');
                dislikePost(postId);
            });

            function likePost(postId) {
                $.ajax({
                url: '{{ route('like') }}',
                type: 'POST',
                data: {post_id: postId, _token: '{{ csrf_token() }}'},
                success: function (response) {
                    if (response.success) {
                        var likesCount = parseInt($('#likes-count-' + postId).text());
                        var dislikesCount = parseInt($('#dislikes-count-' + postId).text());

                        if ($('.like-button[data-post="' + postId + '"]').hasClass('active')) {
                            // Ignore if the like button is already active
                            return;
                        }

                        $('#likes-count-' + postId).text(likesCount + 1);
                        $('#dislikes-count-' + postId).text(dislikesCount > 0 ? dislikesCount - 1 : 0);
                        $('.like-button[data-post="' + postId + '"]').addClass('active');
                        $('.dislike-button[data-post="' + postId + '"]').removeClass('active');
                    }
                }
            });
        }

            function dislikePost(postId) {
                $.ajax({
                    url: '{{ route('dislike') }}',
                    type: 'POST',
                    data: {post_id: postId, _token: '{{ csrf_token() }}'},
                    success: function (response) {
                        if (response.success) {
                            var dislikesCount = parseInt($('#dislikes-count-' + postId).text());
                            var likesCount = parseInt($('#likes-count-' + postId).text());

                            if ($('.dislike-button[data-post="' + postId + '"]').hasClass('active')) {
                                $('#dislikes-count-' + postId).text(dislikesCount - 1);
                                $('.dislike-button[data-post="' + postId + '"]').removeClass('active');
                            } else {
                                $('#dislikes-count-' + postId).text(dislikesCount + 1);
                                $('#likes-count-' + postId).text(likesCount > 0 ? likesCount - 1 : 0);
                                $('.dislike-button[data-post="' + postId + '"]').addClass('active');
                                $('.like-button[data-post="' + postId + '"]').removeClass('active');
                            }
                        }
                    }
                });
            }


            $('.bookmark-button').on('click', function () {
            var postId = $(this).data('post');
            bookmarkPost(postId);
        });

        function bookmarkPost(postId) {
            $.ajax({
                url: '{{ route('bookmark') }}',
                type: 'POST',
                data: {post_id: postId, _token: '{{ csrf_token() }}'},
                success: function (response) {
                    if (response.success) {
                        var bookmarksCount = parseInt($('#bookmarks-count-' + postId).text());
                        $('#bookmarks-count-' + postId).text(bookmarksCount + 1);
                    }
                }
            });
        }


        });
    </script>
@endsection
