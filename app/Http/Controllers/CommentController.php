<?php

namespace App\Http\Controllers;

use App\Comment;
use App\JobProposal;
use App\User;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new Comment;

        $comment->comment = $request->comment;

        $comment->user()->associate($request->user());

        $post = JobProposal::find($request->get('job_proposal_id'));
        $post->comments()->save($comment);

        return back();
    }

    public function replyStore(Request $request)
    {
        $reply = new Comment();

        $reply->comment = $request->get('comment');

        $reply->user()->associate($request->user());

        $reply->parent_id = $request->get('comment_id');

        $post = JobProposal::find($request->get('job_proposal_id'));

        $post->comments()->save($reply);

        return back();

    }
}
