<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exception\HttpResponseException;

use DB;
use App\TokenBlacklist;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        try {
            if (! $token = JWTAuth::attempt($request->only('email', 'password'))) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent' => $e->getMessage()], $e->getStatusCode());
        }

        return $this->generateToken($token);       
    }

    public function authenticateUser()
    {
        return response()->json([
            'message' => 'authenticated_user',
            'data' => JWTAuth::parseToken()->authenticate()
        ]);
    }

    public function generateToken($token)
    {
         return new JsonResponse([
            'message' => 'token_generated',
            'data' => [
                'token' => $token,
            ]
        ]);
    }

    public function invalidateToken() {
        $token = JWTAuth::parseToken();
        $jti = $token->getPayload()['jti'];

        if ($token->invalidate()) {
             $this->blacklistToken($jti, 'Token invalidated.');
             return new JsonResponse(['message' => 'token_invalidated']);
        }
        return new JsonResponse(['message' => 'token_does_not_exist']);
    }

    public function refreshToken() {
        $token = JWTAuth::parseToken();
        $jti = $token->getPayload()['jti'];

        $this->blacklistToken($jti, 'Token refreshed.');

        return new JsonResponse([
            'message' => 'token_refreshed',
            'data' => [
                'token' => $token->refresh(),
            ]
        ]);
    }

    public function blacklistToken($jti, $revocationReason) {
        DB::table('token_blacklist')->insert([
            'jti' => $jti,
            'revocation_reason' => $revocationReason,
            'created_at' => DB::raw('now()'),
            'updated_at' => DB::raw('now()'),
        ]);
    }

    public function getTokenBlacklist(Request $request)
    {
        $tokenBlacklist = TokenBlacklist::get();

        return response()->json([
            'message' => 'token_blacklist',
            'data' => response()->json($tokenBlacklist)
        ]);
    }

}