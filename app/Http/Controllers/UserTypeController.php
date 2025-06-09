<?php
//
//use Illuminate\Http\Request;
//use Laravel\Sanctum\PersonalAccessToken;
//
//public function getUserType(Request $request)
//{
//    // Get the token from header
//    $token = $request->header('token'); // or use 'Authorization'
//
//    if (!$token) {
//        return response()->json(['message' => 'Token is required'], 400);
//    }
//
//    // Strip "Bearer " if present
//    if (str_starts_with($token, 'Bearer ')) {
//        $token = substr($token, 7);
//    }
//
//    // Find the token using Sanctum
//    $accessToken = PersonalAccessToken::findToken($token);
//
//    if (!$accessToken) {
//        return response()->json(['message' => 'Invalid token'], 401);
//    }
//
//    $user = $accessToken->tokenable;
//
//    return response()->json([
//        'role_id' => $user->role_id,
//        'user' => $user,
//    ]);
//}
