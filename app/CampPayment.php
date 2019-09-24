<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CampPayment extends Model
{
    protected $table = 'camps_payments';

    protected $fillable = [
        'reference', 'photo', 'date', 'validated', 'payment_method_id', 'camp_id', 'user_id', 'bank_id'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];
}