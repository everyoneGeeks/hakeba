<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    use HasFactory;

    protected $fillable = ['phone', 'national_id', 'birthday', 'fixed_line', 'address', 're_phone' ,'user_id'];
}
