<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Http\Requests\UpdateCommentRequest;

class CommentController extends Controller
{
    public function update(UpdateCommentRequest $request, string $id)
    {
        $comment = Comment::findOrFail($id);
        $comment->update($request->validated());
        
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);
        $taskId = $comment->commentable_id;
        $comment->delete();
        
        return redirect()->back();
    }
}
