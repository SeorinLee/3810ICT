<?php
// app/Models/Application.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'dob',
        'reason',
        'experience',
        'position_title',
        'video_link',
        'document_link',
        'quiz_result',
        'workshop_info',
        'workshop_result',
        'interview_notes',
        'interview_result',
        'unique_job_plan',
        'unique_job_plan_comments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
