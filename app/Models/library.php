<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class library extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'file'];

    protected $hidden = ['created_at', 'updated_at'];
}
