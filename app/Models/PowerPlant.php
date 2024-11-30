<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PowerPlant extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'power_plants';

    protected $guarded = [];


    /**
     * HasOne Relationship with user
     *
     */

   public function users(){
   return $this->belongsTo(\App\User::class,'user_id','id');
   }

}
