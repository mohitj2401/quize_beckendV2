<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'option1', 'option2', 'option3', 'option4', 'quiz_id', 'correct_option',

    ];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
