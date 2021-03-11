<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SecurityQuestions extends Model
{
    protected $fillable=[
        'client_id',
        'security_question',
        'security_answer',
        'created_at',
        'updated_at'
    ];
}
