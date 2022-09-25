<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'file', 'body', 'status'];

    public function userData(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
