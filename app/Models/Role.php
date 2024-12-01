<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    protected $guarded = [];

    /**
     *  Relationship
     *
     */

   public function users(){
   return $this->belongsToMany(\App\User::class,'user_role');
   }

}
