<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'matric_no', 
        'reg_no', 
        'firstname', 
        'lastname',
        'image',
        'email',
        'slug',
    ];

    /**
     * Get all of the candidates for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }
}
