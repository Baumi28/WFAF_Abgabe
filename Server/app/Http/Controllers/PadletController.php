<?php

namespace App\Http\Controllers;

use App\Models\Padlet;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PadletController extends Controller
{
    public function index(): JsonResponse
    {
        /*
         * load all padlets and relations with eager loading
         */
        $padlets = Padlet::with('users')->get();
        return response()->json($padlets, 200);
    }

    public function findByID(int $id): JsonResponse
    {
        $padlet = Padlet::where('id', $id)->with('users')->first();
        return $padlet != null ? response()->json($padlet, 200)
            : response()->json(null, 200);
    }

    public function checkID(int $id): JsonResponse
    {
        $padlet = Padlet::where('id', $id)->first();
        return $padlet != null ? response()->json(true, 200)
            : response()->json(false, 200);
    }

    public function createPadlet(Request $request): JsonResponse
    {
        //$request = $this->parseRequest($request);
        /*+
        * use a transaction for saving model including relations
        * if one query fails, complete SQL statements will be rolled back
        */

        DB::beginTransaction();
        try {
            $padlet = Padlet::create($request->all());

            DB::commit();
            // return a vaild http response
            return response()->json($padlet, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving padlet failed: " . $e->getMessage(), 420);
        }
    }

    public function deletePadlet(int $id): JsonResponse
    {
        $padlet = Padlet::where('id', $id)->first();
        if ($padlet != null) {
            $padlet->delete();
            return response()->json('padlet (' . $id . ') successfully deleted', 200);
        } else
            return response()->json('padlet could not be deleted - it does not exist', 422);
    }

    public function updatePadlet(string $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            $padlet = Padlet::where('id', $id)->first();

            if ($padlet != null) {
                $padlet->title = request('title');
                $padlet->save();
                DB::commit();
                return response()->json($padlet, 201);
            } else {
                return response()->json('padlet could not be updated - it does not exist', 422);
            }
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("updating padlet failed: " . $e->getMessage(), 420);
        }
    }
}
