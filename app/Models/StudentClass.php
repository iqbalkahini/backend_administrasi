<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentClass extends Model
{
    protected $fillable = ['name', 'school_id'];

    protected $guarded = ["id"];
         
         
    public function schools(): BelongsTo
    {
        return $this->belongsTo(School::class, 'school_id');
    }
    
    public function student () {
        return $this->hasMany(Student::class);
    }
}
