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

    protected $fillable = ['subject', 'description', 'level', 'user_id'];

    public function scopeAvailable($query){
        return $query->where('status', '=', 'available');
    }

    public function scopeRequested($query){
        return $query->where('status', '=', 'requested');
    }

    public function scopeBooked($query){
        return $query->where('status', '=', 'booked');
    }

    public function dates() : HasMany{
        return $this->hasMany(Date::class);
    }

    public function users():BelongsToMany{
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
