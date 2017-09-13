<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
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
 
}