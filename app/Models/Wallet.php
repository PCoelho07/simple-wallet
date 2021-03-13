<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $guarded = [];

    public function canMakeTransfer($value)
    {
        return ($this->value - $value) >= 0;
    }


    public function debit($value)
    {
        $this->value -= $value;
        $this->save();
    }

    public function credit($value)
    {
        $this->value += $value;
        $this->save();
    }
}
