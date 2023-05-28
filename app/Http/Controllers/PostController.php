<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Like;
use App\Models\Dislike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('home', compact('posts'));
    }


    public function create()
    {
        return view('post.createPost');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'description' => 'required|string|max:10000',
        ]);

        $post = new Post();
        $post->description = $validatedData['description'];
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function like(Request $request)
    {
        $postId = $request->input('post_id');
        $post = Post::find($postId);

        $existingLike = Like::where('post_id', $postId)
                            ->where('user_id', auth()->user()->id)
                            ->first();

        $existingDislike = Dislike::where('post_id', $postId)
                                  ->where('user_id', auth()->user()->id)
                                  ->first();

        if (!$existingLike && !$existingDislike) {
            $like = new Like();
            $like->user_id = auth()->user()->id;
            $post->likes()->save($like);
            $post->increment('like_count');
        }elseif($existingDislike) {
            $existingDislike->delete();
            $post->decrement('dislike_count');
            $like = new Like();
            $like->user_id = auth()->user()->id;
            $post->likes()->save($like);
            $post->increment('like_count');
        }

        return response()->json(['success' => true]);
    }

    public function dislike(Request $request)
    {
        $postId = $request->input('post_id');
        $post = Post::find($postId);

        $existingLike = Like::where('post_id', $postId)
                            ->where('user_id', auth()->user()->id)
                            ->first();

        $existingDislike = Dislike::where('post_id', $postId)
                                  ->where('user_id', auth()->user()->id)
                                  ->first();

        if (!$existingLike && !$existingDislike) {
            $dislike = new Dislike();
            $dislike->user_id = auth()->user()->id;
            $post->dislikes()->save($dislike);
            $post->increment('dislike_count');
        }elseif($existingLike) {
            $existingLike->delete();
            $post->decrement('like_count');
            $dislike = new Dislike();
            $dislike->user_id = auth()->user()->id;
            $post->dislikes()->save($dislike);
            $post->increment('dislike_count');
        }

        return response()->json(['success' => true]);
    }


    public function bookmark(Request $request)
    {
        $postId = $request->input('post_id');
        $post = Post::find($postId);

        if ($post) {
            $userId = Auth::user()->id;

            try {
                $post->bookmarks()->attach($userId);
                $post->increment('bookmarks_count');
            } catch (QueryException $e) {
                // Bookmark entry already exists for the user, handle accordingly
                return response()->json(['success' => false]);
            }

            $bookmarksCount = $post->bookmarks_count;

            return response()->json([
                'success' => true,
                'bookmarksCount' => $bookmarksCount
            ]);
        }

        return response()->json(['success' => false]);
    }


}
