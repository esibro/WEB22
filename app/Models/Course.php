<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description', 'level', 'user_id', 'student_id', 'state'];

    public function timeslots() : HasMany{
        return $this->hasMany(Timeslots::class);
    }

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
