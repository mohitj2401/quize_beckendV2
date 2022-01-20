<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Quiz extends Model
{
    use HasFactory;

    public function question()
    {
        return $this->hasMany(Question::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function result()
    {
        return $this->hasMany(Result::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
