<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company_case extends Model
{
    use HasFactory;

    protected $fillable=[
        'company_name', 'case_type', 'client_name', 'phone', 'start_work_date', 'end_work_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function caseType()
    {
        return $this->belongsTo(case_type::class, 'case_type');
    }

}
