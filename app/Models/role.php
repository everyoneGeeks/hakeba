<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;

    protected $fillable= ['name'];

    public function users(){
        return $this->hasMany(user_role::class, 'role_id', 'id')->with('userData');
    }

    protected $hidden=['created_at', 'updated_at'];
}
