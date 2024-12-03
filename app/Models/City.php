<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';
    protected $fillable = ["name"];

    protected $guarded = ["id"];

    public function schools()
    {
        return $this->hasMany(School::class);
    }
    public function student () {
        return $this->hasMany(Student::class);
    }
}
