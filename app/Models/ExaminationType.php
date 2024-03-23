<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExaminationType extends Model
{
    use HasFactory, SoftDeletes;

    const PRODUCT_TYPE_JAMB = 'Jamb';
    const PRODUCT_TYPE_SCHOOL = 'School';

    protected $fillable = [
        'type',
    ];

     /**
     * Get all of the posts for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function examinations()
    {
        return $this->hasMany(Examination::class, 'examination_id', 'id');
    }

    public static function getExamTypeId ( $type ) {
        $type = self::where('type', $type)->first();
        return $type['id'];
    }
}