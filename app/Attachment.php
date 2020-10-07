<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'path',
        'file_type',
        'attachment_type',
        'model_type',
        'model_id',
    ];
}
