<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($channelId, Thread $thread, Request $request)
    {
        $request->validate([
            'body' => 'required',
        ]);
        $reply = $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);
        if ($request->wantsJson()) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'You replied to the thread!');
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
        $reply->update(['body' => request('body')]);
    }
}
