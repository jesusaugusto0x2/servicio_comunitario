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

    public function payments () {
        return $this->hasMany('App\CampPayment');
    }

    public function validated_payments () {
        return $this->hasMany('App\CampPayment')->where('validated', 1);
    }

    public function pending_payments () {
        return $this->hasMany('App\CampPayment')->where('validated', 0);
    }

    public function getData () {

        $photos = $this->photos ? $this->photos : [];
        $validated_payments = $this->validated_payments ? $this->validated_payments : [];
        $pending_payments = $this->pending_payments ? $this->pending_payments : [];
        
        return [
            'id'    =>  $this->id,
            'location'  =>  $this->location,
            'entries'   =>  $this->entries,
            'cost'      =>  $this->cost,
            'date'      =>  $this->date,
            'photos'    =>  $photos,
            'payments'  =>  [
                'validated' =>  $validated_payments,
                'pending'   =>  $pending_payments
            ]
        ];
    }
}