<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Google\Client;   // CORRECT IMPORT
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class LoginaaController extends Controller
{
    // NORMAL LOGIN API
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'status'  => 'success',
                'message' => 'Login successful',
                'user'    => $user,
                'token'   => $token
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'message' => 'Invalid email or password'
        ], 401);
    }

    // GOOGLE LOGIN API
 public function googleLogin(Request $request)
{
    try {
        $client = new Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($request->id_token);

        if (!$payload) {
            return response()->json(['error' => 'Invalid Google Token'], 401);
        }

        $user = User::where('email', $payload['email'])->first();

        if (!$user) {
            $user = User::create([
                'name'        => $payload['name'],
                'email'       => $payload['email'],
                'google_id'   => $payload['sub'],
                'profile_pic' => $payload['picture'],
                'password'    => bcrypt('google-login'),
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'user'    => $user,
            'token'   => $token,
        ], 200);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
