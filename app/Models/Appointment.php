<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class Appointment extends Model
{
    use HasFactory,Notifiable,HasApiTokens;
    protected $fillable =[
        'date',
        'order_id',
    ];
}
