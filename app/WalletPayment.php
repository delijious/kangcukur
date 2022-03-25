<?php

namespace App;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletPayment extends Model
{
    // use HasFactory;

    protected $table = 'wallet_payment';

    protected $fillable = ['booking_id','payment_type','payment_token','added_by'];
}
