<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = "schools";
    protected $fillable = ["name", "city_id"];

    protected $guarded = ["id"];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function classes() {
        return $this->hasMany(StudentClass::class);
    }
    public function student () {
        return $this->hasMany(Student::class);
    }
}
