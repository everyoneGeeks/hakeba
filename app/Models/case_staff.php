<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class case_staff extends Model
{
    use HasFactory;

    protected $fillable=['case_id', 'user_id'];
}
