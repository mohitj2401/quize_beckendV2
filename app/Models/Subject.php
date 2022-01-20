<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'user_id'

    ];
    public function quiz()
    {
        return $this->hasMany(Quiz::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
