<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

    protected $guarded = [];

    /**
     *  Relationship
     *
     */

   public function users(){
   return $this->belongsTo(\App\User::class,'user_id','id');
   }

   public function plants(){
   return $this->belongsTo(\App\Models\PowerPlant::class,'plant_id','id');
   }

   public function blocks(){
   return $this->hasMany(\App\Models\BlockNumber::class,'schdule_id','id');
   }

}
