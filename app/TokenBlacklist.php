<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use DB;
 
class TokenBlacklist extends Model
 
{

   protected $table = 'token_blacklist';
   // Remove timestamps from model
   // public $timestamps = false;
 
   /* 
   This example provides minimal set of blacklist data
	For more sophisticated system, we could include:
	ISS - issuer of the token
	NBF - Not Before timestamp
	IAT - Token Issued timestamp
   */
   protected $fillable = ['jti','revocation_reason'];

   public function exists($jti) 
    {
        if ($isTokenBlacklisted = TokenBlacklist::where('jti', $jti)->first())
        {
            return true;
        }
        return false;
    }
   
   public function addToken($jti, $revocationReason)
   {
      try {
         DB::table('token_blacklist')->insert([
            'jti' => $jti,
            'revocation_reason' => $revocationReason,
            'created_at' => DB::raw('now()'),
            'updated_at' => DB::raw('now()'),
        ]);
      } catch (Illuminate\Database\QueryException $e) {
         return false;
      }
      return true;
   }
}