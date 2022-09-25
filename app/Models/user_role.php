<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    use HasFactory;

    protected $fillable=['user_id', 'role_id'];

    public function roleData(){
        return $this->belongsTo(role::class, 'role_id', 'id');
    }

    public function userData(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    protected $hidden=['created_at', 'updated_at', 'role_id', 'user_id'];

}
