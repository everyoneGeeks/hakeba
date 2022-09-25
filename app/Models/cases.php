<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cases extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'defendant_name', 'defendant_address', 'civil', 'defendant_status', 'case_type',
        'case_date', 'session_date', 'file_office_number', 'file_court_number', 'registration_number', 'circle_case',
        'id_card_file', 'commercial_register_file', 'establishment_contract_file', 'case_document_file', 'note_file',
        'adjust_session_file', 'start_authorization_date', 'end_authorization_date',
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
