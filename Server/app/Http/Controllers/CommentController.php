<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Entry;
use App\Models\Padlet;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function index(): JsonResponse
    {
        /*
         * load all comments and relations with eager loading
         */
        $comments = Comment::with('entry')->get();
        return response()->json($comments, 200);
    }

    public function createComment(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $entryId = $request->input('entry_id');
            $entry = Entry::findOrFail($entryId);

            $commentData = $request->all();
            $commentData['entry_id'] = $entryId;

            $comment = Comment::create($commentData);
            $entry->comments()->save($comment);

            DB::commit();
            return response()->json($comment, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json("saving comment failed: " . $e->getMessage(), 420);
        }
    }

    public function deleteComment(int $id) : JsonResponse {
        $comment = Comment::where('id', $id)->first();
        if ($comment != null) {
            $comment->delete();
            return response()->json('comment (' . $id . ') successfully deleted', 200);
        }
        else
            return response()->json('comment could not be deleted - it does not exist', 422);
    }

}
