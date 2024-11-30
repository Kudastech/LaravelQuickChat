<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageBind extends Model
{
    protected $fillable = [
        'message_id',
        'name',
        'mime',
        'size',
        'path',
    ];
}
