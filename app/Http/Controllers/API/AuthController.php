<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends BaseController
{
    /**
     *    @OA\Get(
     *        path="/api/register",
     *        tags={"Auth"},
     *        summary="Register a new user",
     *        description="Register a new user",
     *        @OA\RequestBody(
     *            required=true,
     *            @OA\JsonContent(
     *                required={"name","email","password","c_password"},
     *                @OA\Property(property="name", type="string", format="name", example="John Doe", description="Name of the user"),
     *                @OA\Property(property="email", type="string", format="email", example=" [email protected]", description="Email of the user"),
     *                @OA\Property(property="password", type="string", format="password", example="password", description="Password of the user"),
     *                @OA\Property(property="c_password", type="string", format="password", example="password", description="Confirm password of the user"),
     *            ),
     *        ),
     *        @OA\Response(
     *            response=200,
     *            description="User register successfully",
     *            @OA\JsonContent(
     *                @OA\Property(property="token", type="string", example="token", description="User token"),
     *                @OA\Property(property="name", type="string", example="John Doe", description="Name of the user"),
     *            ),
     *        ),
     *      ),
     *  )
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('Juicebox')->plainTextToken;
        $success['name'] = $user->name;

        // Dispatch the welcome email job
        SendWelcomeEmailJob::dispatch($user);

        return $this->sendResponse($success, 'User register successfully.');
    }

    /**
     *    @OA\Get(
     *        path="/api/login",
     *        tags={"Auth"},
     *        summary="Login a user",
     *        description="Login a user",
     *        @OA\RequestBody(
     *            required=true,
     *            @OA\JsonContent(
     *                required={"email","password"},
     *                @OA\Property(property="email", type="string", format="email", example=" [email protected]", description="Email of the user"),
     *                @OA\Property(property="password", type="string", format="password", example="password", description="Password of the user"),
     *            ),
     *        ),
     *        @OA\Response(
     *            response=200,
     *            description="User login successfully",
     *            @OA\JsonContent(
     *                @OA\Property(property="token", type="string", example="token", description="User token"),
     *                @OA\Property(property="name", type="string", example="John Doe", description="Name of the user"),
     *            ),
     *        ),
     *      ),
     *  )
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('Juicebox')->plainTextToken;
            $success['name'] = $user->name;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     *   @OA\Get(
     *       path="/api/logout",
     *      tags={"Auth"},
     *      summary="Logout a user",
     *     description="Logout a user",
     *    @OA\Response(
     *       response=200,
     *      description="User logged out successfully",
     *    @OA\JsonContent(
     *      @OA\Property(property="message", type="string", example="User logged out successfully", description="Message"),
     *   ),
     * ),
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->sendResponse([], 'User logged out successfully.');
    }
}
