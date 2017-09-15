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

use App\TokenBlacklist;

class TokenController extends Controller
{

    public function generateToken($token)
    {
        /*
         Small wrapper method, additional work on token can be included here...
         */
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
             return $this->blacklistToken($jti, 'token_invalidated');
        }
        return new JsonResponse(['message' => 'token_does_not_exist']);
    }

    public function refreshToken() {
        $token = JWTAuth::parseToken();
        $jti = $token->getPayload()['jti'];

        $this->blacklistToken($jti, 'token_refreshed');

        return new JsonResponse([
            'message' => 'token_refreshed',
            'data' => [
                'token' => $token->refresh(),
            ]
        ]);
    }

    public function blacklistToken($jti, $revocationReason) {

        if((new tokenBlacklist())->exists($jti)) 
        {
            return new JsonResponse([
                'message' => 'token_already_blacklisted',
            ]);
        }

        $tokenBlacklist = new TokenBlacklist();
        $response = $tokenBlacklist->addToken($jti, $revocationReason);
        // we can do additional error handling based on $response

        return new JsonResponse([
                'message' => $revocationReason,
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

    public function isTokenBlacklisted($jti)
    {
        $tokenBlacklist = new TokenBlacklist();
        if ($tokenBlacklist->exists($jti)) {
            return response()->json([
                    'message' => 'token_blacklisted',
            ]);
        }

        return response()->json([
            'message' => 'token_not_blacklisted',
        ]);
    }

    public function createTokenBlacklistEntry(Request $request, $jti)
    {
        // Question2MySelf: Should this function also include token REVOKING or simply add it to blacklist?! :) hmm...
        return $this->blacklistToken($jti, 'token_blacklisted_by_api');
    }

   

}