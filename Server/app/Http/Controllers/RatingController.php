<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Entry;
use App\Models\Padlet;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function createRating(Request $request): JsonResponse
    {
        //$request = $this->parseRequest($request);
        /*+
        * use a transaction for saving model including relations
        * if one query fails, complete SQL statements will be rolled back
        */

        DB::beginTransaction();
        try {
            $rating = Rating::create($request->all());

            DB::commit();
            // return a vaild http response
            return response()->json($rating, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving user failed: " . $e->getMessage(), 420);
        }
    }

    public function deleteRating(int $id): JsonResponse
    {
        $rating1 = Rating::where('id', $id)->first();
        if ($rating1 != null) {
            $rating1->delete();
            return response()->json('rating (' . $id . ') successfully deleted', 200);
        } else
            return response()->json('rating could not be deleted - it does not exist', 422);
    }
}
