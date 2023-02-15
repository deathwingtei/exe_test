<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'username',
        'company',
        'nationality',
    ];

    protected function serializeDate($date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
