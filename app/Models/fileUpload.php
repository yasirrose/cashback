<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fileUpload extends Model
{

    use HasFactory;

    protected $table = 'file_upload';

    protected $fillable = [
        'file_name',
    ];
}
