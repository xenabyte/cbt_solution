<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CandidateExamSubject extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'examination_id',
        'candidate_id', 
        'subject_id',
        'question_quantity',
        'question_mark',
        'student_score', 
    ];

    protected $table = 'candidate_exam_subjects';

    /**
     * Get the candidate that owns the CandidateExamSubject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function candidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate_id');
    }

    /**
     * Get the examination that owns the CandidateExamSubject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function examination()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    /**
     * Get the question that owns the CandidateExamSubject
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    /**
     * Get all of the question for the CandidateExamSubject
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function question()
    {
        return $this->hasMany(CandidateQuestion::class, 'candidate_exam_subject_id', 'id');
    }

}
