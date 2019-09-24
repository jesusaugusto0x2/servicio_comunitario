<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camp extends Model
{
    protected $table = 'camps';
    
    protected $fillable = [
        'location', 'entries', 'cost', 'date'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}
