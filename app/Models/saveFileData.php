<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class saveFileData extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'upload_file_record';

    protected $guarded = [];
}
