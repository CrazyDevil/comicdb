<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

/**
 * @group Private
 * @header Accept application/json
 */
class RegisterController extends Controller
{
    /**
     * @unauthenticated
     * @group Public
     *
     * @header Accept application/json
     *
     * @response {
     *     "access_token": "token",
     *     "token_type": "Bearer",
     * }
     *
     * @response 422 {
     *   "message": "The given data was invalid.",
     *   "errors": {
     *   "name": [
     *     "Error message."
     *   ]
     * }
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('all_access')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
