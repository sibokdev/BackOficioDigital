<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AuditDocuments extends Model
{
    protected $table = 'audits_has_documents';

    protected $fillable=[
        'audit_id',
        'document_id',
        'created_at',
        'updated_at',
    ];
}