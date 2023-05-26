<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id', 
        'examination_id', 
        'result'
    ];

    /**
     * Get the exam that owns the Candidate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function examination()
    {
        return $this->belongsTo(Examination::class, 'examination_id');
    }

    /**
     * Get the student that owns the Candidate
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
