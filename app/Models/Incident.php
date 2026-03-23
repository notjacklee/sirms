<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'title',
        'category',
        'severity',
        'description',
        'status_id',
        'reporter_id',
        'assigned_to',
    ];

    // Incident status
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Reporter (user who submitted incident)
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    // Assigned officer
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Investigation notes / comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Evidence attachments
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    // Audit logs / incident timeline
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class)->orderBy('created_at', 'desc');
    }
}