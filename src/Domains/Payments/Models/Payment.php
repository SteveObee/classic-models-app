<?php

namespace Domains\Payments\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'customerNumber';

    protected $casts = [
        'paymentDate' => 'datetime:Y-m-d'
    ];

}
