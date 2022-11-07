<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashbackOffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'affiliate_url'
    ];
}
