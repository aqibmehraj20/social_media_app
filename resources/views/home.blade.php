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
                                                <img height="300px" src="{{ asset('storage/post/'.$post->image) }}" >
                                                <p>{{ $post->description }}</p>
                                            </div>
                                            <span id="likes-count-{{ $post->id }}">{{ $post->like_count }}</span><button class="like-button{{ $post->likedByUser() ? ' active' : '' }}" data-post="{{ $post->id }}" style="border: none; color: #fff;"> <img src="{{ asset('img/like.png') }}" height="25px" width="25px" /></button>
                                            <span id="dislikes-count-{{ $post->id }}">{{ $post->dislike_count }}</span><button class="dislike-button{{ $post->dislikedByUser() ? ' active' : '' }}" data-post="{{ $post->id }}" style="border: none; color: #fff;"> <img src="{{ asset('img/dislike.png') }}" height="30px" width="30px" /></button>
                                            <span id="bookmarks-count-{{ $post->id }}">{{ $post->bookmarks_count }}</span><button class="bookmark-button" data-post="{{ $post->id }}" style="border: none; color: #fff;"> <img src="{{ asset('img/bookmark.png') }}" height="30px" width="30px" /></button>
                                           <hr>
                                            <h4>Comments</h4>


                                        <div class="comments-section">

                                            <!-- Display comments -->
                                            @foreach ($post->comments as $comment)
                                                <div class="comment">
                                                    <div class="file-box">
                                                    <div class="profile-pic">
                                                    <img src="{{ asset('storage/profile_pictures/'.$comment->user->profile_picture) }}" alt="Profile Picture">
                                                </div>
                                                <span style="color:#4267B3"><b>{{ $comment->user->name }}</b></span>

                                                </div>
                                                    <p>{{ $comment->content }}</p>
                                                    <div class="comment-actions">
                                                        <button  style="border: none; color: #4267B3;" class="comment-like-button" data-comment-id="{{ $comment->id }}">Like</button>
                                                        <span class="comment-like-count">{{ $comment->likes }}</span>
                                                        <button  style="border: none; color:#4267B3;" class="comment-dislike-button" data-comment-id="{{ $comment->id }}">Dislike</button>
                                                        <span class="comment-dislike-count">{{ $comment->dislikes }}</span>
                                                    </div>
                                                </div>
                                            @endforeach

                                            <!-- Add comment form -->
                                            <form id="comment-form-{{ $post->id }}" class="comment-form" data-post="{{ $post->id }}">
                                                <textarea name="comment" class="comment-input" placeholder="Add a comment"></textarea>

                                                <span ></span><button type="submit" class="comment-submit" style="border: none; color: #fff;"> <img src="{{ asset('img/comment.png') }}" height="30px" width="30px" style="margin-bottom: 50px;" /></button>
                                            </form>


                                        </div>
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

        $('.comment-form').on('submit', function(event) {
            event.preventDefault();

            var commentContent = $(this).find('.comment-input').val();
            var postId = $(this).data('post');

            if (commentContent.trim() === '') {
                return;
            }

            var commentForm = $(this); // Store the comment form reference

            $.ajax({
                type: 'POST',
                url: '/comment/add',
                data: {
                    post_id: postId,
                    content: commentContent,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        var commentSection = commentForm.closest('.comments-section');

                        var newComment = $('<div class="comment">');
                        newComment.html('<p>' + commentContent + '</p>' +
                            '<div class="comment-actions">' +
                            '<button  style="border: none; color: #4267B3;" class="like-button" data-comment-id="' + response.comment.id + '">Like</button>' +
                            '<span class="like-count">0</span>' +
                            '<button  style="border: none; color: #4267B3;" class="dislike-button" data-comment-id="' + response.comment.id + '">Dislike</button>' +
                            '<span class="dislike-count">0</span>' +
                            '</div>');

                        commentSection.prepend(newComment);

                        commentForm.find('.comment-input').val(''); // Clear the comment input
                    }
                }
            });
        });

            // Like button click handler for comments
            $(document).on('click', '.comment-like-button', function(event) {
                event.preventDefault();

                var commentId = $(this).data('comment-id');

                $.ajax({
                    type: 'POST',
                    url: '/comment/like',
                    data: {
                        comment_id: commentId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            var likeCountElement = $('.comment-like-count[data-comment-id="' + commentId + '"]');
                            likeCountElement.text(response.likes);
                        }
                    }
                });
            });

            // Dislike button click handler for comments
            $(document).on('click', '.comment-dislike-button', function(event) {
                event.preventDefault();

                var commentId = $(this).data('comment-id');

                $.ajax({
                    type: 'POST',
                    url: '/comment/dislike',
                    data: {
                        comment_id: commentId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            var dislikeCountElement = $('.comment-dislike-count[data-comment-id="' + commentId + '"]');
                            dislikeCountElement.text(response.dislikes);
                        }
                    }
                });
            });


        });
    </script>
@endsection
