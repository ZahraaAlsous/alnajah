<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Model
{
    use HasFactory,Notifiable,HasApiTokens;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'address',
        'salary',
        'type',
        'year',
    ];
}
