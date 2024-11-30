<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlockNumber extends Model
{
        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'block_numbers';

    protected $guarded = [];

    public function schedules(){
    return $this->belongsTo(\App\Models\Schedule::class,'schdule_id','id');
    }

}
