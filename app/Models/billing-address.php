<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billingaddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kana_name',
        'address',
        'tel',
        'BillingDepartment',
        'kana_BillingDepartment',
    ];
}
