<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use App\Http\Forms\CreatePostForm;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, CreatePostForm $form)
    {
        return $form->persist($thread);
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return response(['status' => 'Replie deleted']);
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            request()->validate(['body' => ['required', new SpamFree]]);

            $reply->update(['body' => request('body')]);
        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.',
                422
            );
        }
    }
}
