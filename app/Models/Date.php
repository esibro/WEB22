<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Date extends Model
{
    use HasFactory;

    protected $fillable = ['date'];

    public function course():BelongsTo{
        return $this->belongsTo(Course::class);
        // circular references OR mapping, big issue
    }
}
