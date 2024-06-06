<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class customer extends User
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded =[];
}
