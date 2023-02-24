<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameRecords extends Model
{
    protected $primaryKey = "id";
    public $timestamps = false;

    protected $fillable = [
        'event_id',
        'got_money',
        'create_date'
    ];
}
