<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //白名单
    protected $fillable = ['content'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
