<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'subject',
        'examination_type_id',
        'code',
        'description'
    ];

     /**
     * Get all of the posts for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Questions::class, 'subject_id', 'id');
    }

    public static function getExamTypeId ( $type ) {
        $type = self::where('type', $type)->first();
        return $type['id'];
    }
}
