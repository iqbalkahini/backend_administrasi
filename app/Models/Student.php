<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    protected $fillable = ["city_id","school_id", "class_id", "user_id"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function class(): BelongsTo
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}
