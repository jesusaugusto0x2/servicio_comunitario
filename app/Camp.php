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

    public function photos () {
        return $this->hasMany('App\CampPhoto');
    }

    public function getData () {

        $photos = $this->photos ? $this->photos : [];

        return [
            'id'    =>  $this->id,
            'location'  =>  $this->location,
            'entries'   =>  $this->entries,
            'cost'      =>  $this->cost,
            'date'      =>  $this->date,
            'photos'    =>  $photos
        ];
    }
}