<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Padlet;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    public function loadEntries(): JsonResponse
    {
        /*
         * load all entries and relations with eager loading
         */
        $entries = Entry::with('comments', 'ratings')->get();
        return response()->json($entries, 200);
    }

    public function showCommentsOfEntry(int $id): JsonResponse
    {
        /*
         * load all comments of a certain entry
         */
        $entry = Entry::with(['comments'])->where('id', $id)->first();
        $comments = $entry->comments;
        return response()->json($comments, 200);
    }

    public function showEntriesOfPadlet(int $id): JsonResponse
    {
        /*
         * load all comments of a certain entry
         */
        $padlet = Padlet::with(['entries.comments', 'entries.ratings'])->where('id', $id)->first();
        $entries = $padlet->entries;
        return response()->json($entries, 200);
    }

    public function createEntry(Request $request): JsonResponse
    {
        //$request = $this->parseRequest($request);
        /*+
        * use a transaction for saving model including relations
        * if one query fails, complete SQL statements will be rolled back
        */

        DB::beginTransaction();
        try {
            $entry = Entry::create($request->all());

            DB::commit();
            // return a vaild http response
            return response()->json($entry, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving entry failed: " . $e->getMessage(), 420);
        }
    }

    public function deleteEntry(int $id): JsonResponse
    {
        $entry = Entry::where('id', $id)->first();
        if ($entry != null) {
            $entry->delete();
            return response()->json('entry (' . $id . ') successfully deleted', 200);
        } else
            return response()->json('entry could not be deleted - it does not exist', 422);
    }

    public function updateEntry(Request $request, string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $entry = Entry::where('id', $id)->first();

            if ($entry != null) {
                $entry->title = $request->input('title');
                $entry->description = $request->input('description');
                $entry->save();
                DB::commit();
                return response()->json($entry, 201);
            } else {
                return response()->json('entry could not be updated - it does not exist', 422);
            }
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating entry failed: " . $e->getMessage(), 420);
        }
    }
}
