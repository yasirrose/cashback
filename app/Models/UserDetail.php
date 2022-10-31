<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;   /** USE HasApiTokens **/

class UserDetail extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'user_detail';
    protected $fillable = [
        'user_id',
        'organization_name',
        'type',
        'billing_address',
    ];
}
