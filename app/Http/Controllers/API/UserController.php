<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * @OA\Get(
     *   path="/api/users/{id}",
     *  tags={"Users"},
     * summary="Get a user",
     * description="Get a user",
     * @OA\Parameter(
     *  name="id",
     * in="path",
     * description="ID of the user",
     * required=true,
     * @OA\Schema(
     * type="integer",
     * ),
     * ),
     * @OA\Response(
     * response=200,
     * description="User retrieved successfully",
     * @OA\JsonContent(
     * @OA\Property(property="data", type="object", ref="#/components/schemas/User"),
     * ),
     * ),
     * )
     */
    public function show($id)
    {
        //Get the user
        $user = User::find($id);

        //Check if the user exists
        if (is_null($user)) {
            return response()->json(['message' => 'User not found'], 404);
        }

        //Return the user
        return $this->sendResponse($user->toArray(), 'User retrieved successfully.');
    }
}
