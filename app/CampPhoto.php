<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampPhoto extends Model
{
    protected $table = 'camps_photos';

    protected $fillable = [
        'url', 'camp_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
