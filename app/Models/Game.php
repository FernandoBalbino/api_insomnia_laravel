<?php

namespace App\Models;

use App\Constants\Table;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $table = Table::GAMES;

    protected $fillable = [
        'name',
        'description',
        'thumb',
        'video',
        'release_date'
    ];
}
