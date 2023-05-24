<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Models\Padlet;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function loadUsers(): JsonResponse
    {
        /*
         * load all users and relations with eager loading
         */
        $users = User::with('padlets')->get();
        return response()->json($users, 200);
    }

    public function createUser(Request $request): JsonResponse
    {
        //$request = $this->parseRequest($request);
        /*+
        * use a transaction for saving model including relations
        * if one query fails, complete SQL statements will be rolled back
        */

        DB::beginTransaction();
        try {
            $user = User::create($request->all());

            DB::commit();
            // return a vaild http response
            return response()->json($user, 201);
        } catch (\Exception $e) {
            // rollback all queries
            DB::rollBack();
            return response()->json("saving user failed: " . $e->getMessage(), 420);
        }
    }

    public function deleteUser(int $id) : JsonResponse {
        $user = User::where('id', $id)->first();
        if ($user != null) {
            $user->delete();
            return response()->json('user (' . $id . ') successfully deleted', 200);
        }
        else
            return response()->json('user could not be deleted - it does not exist', 422);
    }
}
