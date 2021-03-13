<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const SUCCESS = 'success';
    const FAILED = 'failed';

    protected $guarded = [];

    public function from()
    {
        return $this->belongsTo('App\Models\User', 'user_source_id');
    }

    public function to()
    {
        return $this->belongsTo('App\Models\User', 'user_target_id');
    }
}
