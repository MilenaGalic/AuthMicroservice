<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
use DB;
 
class Permission extends Model
 
{
 
   protected $fillable = ['name','description'];

}